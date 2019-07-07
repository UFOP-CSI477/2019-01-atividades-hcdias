<div class="modal fade" id="cart-modal" tabindex="-1" role="dialog" aria-labelledby="cartLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cartLabel">{{ __('Cart items') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>{{ __('Confirm your tests')}}</p>
        <div class="row">
            <div class="table-responsive">
              <table class="table" id="cart-table">
                <thead class="text-primary">
                  <tr>
                    <th>{{__('Procedure')}}</th>
                    <th>{{__('Date')}}</th>
                    <th>{{__('Price')}}</th>
                    <th>{{__('Remove')}}</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
              <form id="cart-form"></form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="button" class="btn btn-primary" id="cart-finish">{{ __('Finish') }}</button>
      </div>
    </div>
  </div>
</div> 
@push('js')
  <script>
    $(document).ready(function() {
        //inicia o carrinho, se ja houver sessão recupera do storage
        let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
        //atualiza o contador do carrinho
        $("#notification-count").text(cart.length);

        //monta o html dos elementos do carrinho
        let itemCart = function(date,id,price,name){
          this.id = id;
          this.price = price;
          this.name = name;
          this.date = date;
          this.html = generateHTML();

          function generateHTML(){
            let string = '<tr>\
              <td>\
                @name\
              </td>\
              <td>\
                @date\
              </td>\
              <td>\
                @preco\
              </td>\
              <td>\
                <i class="material-icons remove-item" data-id="@id" >close</i>\
              </td>\
            </tr>';
            string = string.replace("@name",name)
                    .replace("@date",date)
                    .replace("@preco",price)
                    .replace("@id",id);  
            return string;
          }
        }

        //monta o html do carrinho
        let cartBuild = function(item){
          this.total = 0;
          this.html = '';
          for(i in item){
            this.total += parseFloat(item[i].price);
            this.html += item[i].html;
          }

          this.generateHTML = function(){
            return this.html;
          }

          this.sum = function(){
            let string = '<td><b>TOTAL</b></td><td></td><td><b>@sum</b></td><td></td>';
            string = string.replace("@sum",this.total.toFixed(2));
            return string;
          }

          this.fillForm = function(){
            let input = '<input type="hidden" name="test[]" value="@id"><input type="hidden" name= "date[]" value="@date">';
            let html = '';
            for(i in item){
              html += input.replace("@id",item[i].id).replace("@date",item[i].date);
            }

            return html;
          }
        }

        //exibe notificacoes de sucesso 
        let msgSuccess = function(msg){
            $.notify({
              icon: "add_alert",
              message: msg

              },{
                  type: 'success',
                  timer: 3000,
                  placement: {
                      from: 'top',
                      align: 'center'
                  },
            });
        }

        //exibe notificacoes de erro 
        let msgError = function(msg){
            $.notify({
              icon: "add_alert",
              message: msg

              },{
                  type: 'danger',
                  timer: 3000,
                  placement: {
                      from: 'top',
                      align: 'center'
                  }
            });
        }

        //exibe e atualiza o carrinho de tests
        $("#navbarDropdownMenuLink").click(function(){
            let build = new cartBuild(cart);
            $("#cart-table > tbody").html(build.generateHTML()+build.sum());
            $("#cart-modal").modal();

        }.bind(this));

        //insere os dados do test na modal de confirmação
        $(".test-request").click(function(){
            let procedureId = $(this).data('procedure-id');
            let procedurePrice = $(this).data('procedure-price');
            let procedureName = $(this).data('procedure-name');

            $("#procedure-id").val(procedureId);
            $("#procedure-price").val(procedurePrice);
            $("#procedure-name").val(procedureName);
        });

        //salva os itens do carrinho e atualiza o contador de notificação
        $('#schedule-test').click(function(){
            let date = $("#procedure-date").val();
            let procedureId = $("#procedure-id").val();
            let procedurePrice = $("#procedure-price").val();
            let procedureName = $("#procedure-name").val();
            if(date === ""){
                $("#date-container").addClass('has-danger');
                return false;
            }else{
                $("#date-container").removeClass('has-danger');
                item = new itemCart(date,procedureId,procedurePrice, procedureName);

                cart.push(item);
                sessionStorage.setItem('cart',JSON.stringify(cart));
                $("#notification-count").text(cart.length);
                $("#test-request").modal('hide');
                msgSuccess("Exame adicionado ao carrinho!");            
            }

                
        }.bind(this));

        $("#cart-finish").click(function(){
            if(cart.length !== 0){
              build =  new cartBuild(cart);
              $("#cart-form").html(build.fillForm());
              let url = '/tests';
              let data = $("#cart-form").serialize();

              $.ajax({
                    url:url,
                    type:'POST',
                    dataType:'json',
                    data:data,
                    headers:{
                        'X-CSRF-Token':'{{ csrf_token() }}'
                    },
                    beforeSend:function(){
                       
                    }
                })
              .done(function(data){
                if(data.status){
                    sessionStorage.removeItem('cart');
                    cart = [];
                    $("#notification-count").text(cart.length);
                    $("#cart-table > tbody").html("");
                    $("#cart-modal").modal('hide');
                    msgSuccess("Seus exames foram agendados com sucesso.");    
                }
                
              })
              .fail(function(){
                $("#cart-modal").modal('hide');
                msgError('Ocorreu um erro ao realizar o pedido.');
              });
            }else{
              alert('Carrinho vazio');
            }
          
        }.bind(this)); 

    });
  </script>
@endpush