<style>
    .dados{
        font-size: 15px;

    }

  
</style>

<div class="card card-custom gutter-b">
    <div class="card-header">
        <h3 class="card-title tipo-endereco">Endereços</h3>
        <div class="card-toolbar">
            <button onClick="novoEndereco()" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <circle fill="#000000" cx="9" cy="15" r="6" />
                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                        </g>
                    </svg>
                </span>Novo endereço</button>
            </div>
    </div>
    <div class="card-body">
        <div class="row" id="card-enderecos" >
            
                
           
        </div>  
    </div>

</div>

<div>{{$user->id}}</div>
<div class="modal" tabindex="-1" role="dialog" id="modalEnderecos">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formEndereco">
                <div class="modal-header">
                    <h5 class="modal-title">Novo endereço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="id" class="form-control">
                    <input type="hidden" id="user"  class="form-control" value="{{$user->id}}">
                    
                    <div class="row">
                        <div class="form-group col-5">
                            <label for="tipo" class="control-lable">Tipo</label>
                            <div class="input-group">
                                <select class="form-control" name="tipo" id="tipo"></select>
                            </div>
                        </div>
                        <div class="form-group col-7">
                            <label for="cep" class="control-lable">CEP</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="cep" id="cep">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-8">
                            <label for="logradouro" class="control-lable">Logradouro</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="logradouro" id="logradouro">
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label for="numero" class="control-lable">Número</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="numero" id="numero">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="bairro" class="control-lable">Bairro</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="bairro" id="bairro">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-8">
                            <label for="cidade" class="control-lable">Cidade</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="cidade" id="cidade">
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label for="estado" class="control-lable">Estado</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="estado" id="estado">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="complemento" class="control-lable">Complemento</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="complemento" id="complemento">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                    <button type="submit" class="btn btn-success m-5">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    <script>

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });

        function novoEndereco(){
            $('#id').val('');
            $('#logradouro').val('');
            $('#numero').val('');
            $('#cep').val('');
            $('#bairro').val('');
            $('#cidade').val('');
            $('#estado').val('');
            $('#modalEnderecos').modal('show');
        }

        function carregarTipos(){
            $.getJSON('/api/tipo-endereco', function(data){
                for(i=0; i < data.length; i++){
                    opcao = '<option value = "'+ data[i].id +'">' + data[i].descricao +'</option>';
                    $('#tipo').append(opcao);
                }
            });
        } 

        function remover(id){
            $.ajax({
                type: "DELETE",
                url: "/api/enderecos/deletar/" + id ,
                context: this,
                success: function(){
                    console.log("Deletou");
                    $(`#card-enderecos>#card${id}`).remove();
                   
                },
                error: function(){
                    console.log(error);
                }
            });
        }

        function constroiCard(indice){
          
                var card = `
                <div class='card card-custom m-3' id="card${indice}">
                    <div class='card-header'>
                        <div class='card-title'>
                           
                        </div>
                    </div> 
                    <div class='card-body dados' data-scroll='true' data-height='150'>
                        
                        
                    </div>
                    <div class='card-footer d-flex justify-content-center'>
                        <a href='#' class='btn btn-outline-primary font-weight-bold' onclick="editar(${indice})">Editar</a>
                        <a href='#' class='btn btn-outline-danger font-weight-bold ' onclick="remover(${indice})">Excluir</a>
                    </div>
                </div>`
            
                return card;   
        }

        function preencherTitulo(e){
            var titulo = "<h4>" + e.tipo_enderecos_id + "</h4>" ;
            return titulo;
        }

       function preencherCard(e){
            var corpo = 
                "<p>" + e.logradouro + ", <span>" + e.numero + "</span></p>" +
                "<p>" + e.bairro + " - <span>"  + e.cep + "</span></p>" +
                "<p>" + e.cidade  + " - <span>" + e.estado + "</span></p>" ;
            return corpo;
       }


       function carregarEnderecos(){
            
           $.getJSON('/api/enderecos', function(enderecos){

                for(i=0; i < enderecos.length; i++){
                    indice = enderecos[i].id;

                    console.log(indice);
                    card = constroiCard(indice);

                    $('#card-enderecos').append(card);
                    titulo = preencherTitulo(enderecos[i]);
                    dados = preencherCard(enderecos[i]);
                    $(`#card-enderecos>#card${indice}>.card-header>.card-title`).append(titulo);
                    $(`#card-enderecos>#card${indice}>.card-body`).append(dados);
                }
           });
       }

       function criarEndereco(){
           e = {
                logradouro: $('#logradouro').val(),
                numero: $('#numero').val(),
                bairro: $('#bairro').val(),
                cep: $('#cep').val(),
                cidade: $('#cidade').val(),
                estado: $('#estado').val(),
                tipo: $('#tipo').val(),
                user_id : $('#user').val()
            }
            
            $.post('/api/enderecos', e, function(data){
                endereco = JSON.parse(data);

                    card = constroiCard(endereco.id);
                    $('#card-enderecos').append(card);
                    titulo = preencherTitulo(endereco);
                    dados = preencherCard(endereco);
                    $(`#card-enderecos>#card${endereco.id}>.card-header>.card-title`).append(titulo);
                    $(`#card-enderecos>#card${endereco.id}>.card-body`).append(dados);
              
            });
       }

       $('#formEndereco').submit( function(event){
            event.preventDefault();
            criarEndereco();
            $('#modalEnderecos').modal('hide');
       });
        
        $(function(){
            carregarTipos();
            carregarEnderecos();
        });

    </script>
@endsection