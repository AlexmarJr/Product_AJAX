@extends('layouts.main')

@section('content')
    <div class="container" style="background-color: rgb(255, 255, 254); border: 2px solid wheat; border-radius: 25px; padding: 35px">
        <form action="">
            <h2 style="text-align: center">Novo Cadastro</h2>
            <hr>
            <input type="hidden" name='id_prod' id="id_prod" value="">
            <div class="row"> 
                <div class="col-3">
                    <label>Nome</label>
                    <input class="form-control" type="text" name="name" id="name">
                </div>
                <div class="col-3">
                    <label>Tipo</label>
                    <select class="selectpicker" name="type" id="type">
                        <option value="empty">Não Definido</option>
                        <option value="drink">Bebida</option>
                        <option value="food">Comida</option>
                    </select>
                </div>
                <div class="col-3">
                    <label>Quantidade</label>
                    <input class="form-control" type="text" name="quant" id="quant">
                </div>
                <div class="col-3">
                    <label>Preço</label>
                    <input class="form-control" type="text" name="price" id="price">
                </div>

                <div class="col-12" style="padding: 15px">
                    <button class="btn btn-success float-left" id="btn_save" style="" type="button" onclick="post_data()"> <i class="fa fa-plus"></i> Adicionar</button>
                    <button class="btn btn-success float-left" id="btn_update" style="display: none" type="button" onclick="update_data()"> <i class="fa fa-edit"></i> Editar</button>
                    <a href="" class="btn btn-danger float-right remove"> <i class="fa fa-trash"></i> Remover Todos</a>
                </div>
            </div>
            
            <hr>


        </form>
        <h1 style="text-align: center">Produtos Cadastrados</h1>
        <table class="table table-striped" id="dataTable">
            <thead class="thead-dark">
                <tr>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>






<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function getRecords() {
        
        $.ajax({
            url: 'product/data',
            type: "get",
            dataType: 'json',
            success: function (data) {
                var s = '';
                
                var html='';
                data.forEach(function(row){
                    if(row.price == "Ativo"){ s = 'color: green'}else{s = 'color: red'};
                    html += '<tr>'
                    html += '<td>' + row.name + '</td>'
                    html += '<td>' + row.type + '</td>'
                    html += '<td>' + row.quant + '</td>'
                    html += '<td style="' + s + '">' + row.price + '</td>'
                    html += '<td>'
                    html += '<button  class="btn btn-xs btn-warning btnEdit" data-id="' + row.id + '" title="Edit Record" >Edit</button> &nbsp &nbsp'
                    html += '<button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' + row.id + '" title="Delete Record">Delete</button>'
                    html += '</td> </tr>';
                })

                    $('#dataTable').DataTable().destroy();

                    $('table tbody').html(html)
                    
                        $('#dataTable').DataTable({
                            "oLanguage": {
                                "sSearch": "Procurar",
                            },
                            "processing": true,
                            responsive: true,
                            autoWidth: false,
                            "searching": true,
                            "entries": true,
                            "paging":   true
                        });
                }
        })
    }
    getRecords()


    function post_data() {
        var name = $('#name').val();
        var type = $('#type').val();
        var price = $('#price').val();
        var quant = $('#quant').val();
    $.ajax({
        type: 'post',
        url: "{{ route('post.data') }}",
        data: {
            'name': $('#name').val(),
            'type': $('#type').val(),
            'price': $('#price').val(),
            'quant': $('#quant').val(),
        },
        success: function() {
            swal('Produto Registrado');
            $('#name').val('');
            $('.selectpicker').val('');
            $('#quant').val('');
            $('#price').val('');
            $('.selectpicker').selectpicker('refresh');
           
            getRecords()
            
        },
    });
}
    function update_data() {
        var name = $('#name').val();
        var type = $('#type').val();
        var price = $('#price').val();
        var quant = $('#quant').val();
        var id_prod = $('#id_prod').val();
    $.ajax({
        type: 'POST',
        url: "{{ route('update.data') }}",
        data: {
            'id_prod': $('#id_prod').val(),
            'name': $('#name').val(),
            'type': $('#type').val(),
            'price': $('#price').val(),
            'quant': $('#quant').val(),
        },
        success: function() {
            swal('Produto Alterado');
            $('#name').val('');
            $('.selectpicker').val('');
            $('#quant').val('');
            $('#price').val('');
            $('.selectpicker').selectpicker('refresh');

            $('#btn_save').css({'display': 'block'});
            $('#btn_update').css({'display': 'none'});

           
            getRecords();
            
        },
    });
}



$('table').on('click', '.btnDelete', function () {
    var id = $(this).data('id');
    var data={id:id}

    swal({
        title: 'Você tem Certeza?',
        text: 'Fazendo isso você ira Desativar este Cadastro',
        icon: 'warning',
        buttons: ["Cancelar!", "Sim!"],
    }).then(function(value) {
        if (value) {

            $.ajax({
                method: 'POST',
                url: 'product/delete',
                data:data,
                success: function () {
                    swal('Cadastro Deletado');

                    
                    getRecords();
                }
            })
        }
    });
})

$('table').on('click', '.btnEdit', function () {
    var id = $(this).data('id');
    var data={id:id}

    $.ajax({
        method: 'POST',
        url: 'product/edit',
        data:data,
        success: function (response) {
            $('#name').val(response.name);
            $('.selectpicker').val(response.type);
            $('#quant').val(response.quant);
            $('#price').val(response.price);
            $('#id_prod').val(response.id);

            $('.selectpicker').selectpicker('refresh');

            

            $('#btn_save').css({'display': 'none'});
            $('#btn_update').css({'display': 'block'});

         
        }
    })
})


</script>
@endsection
