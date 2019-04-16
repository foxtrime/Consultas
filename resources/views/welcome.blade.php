@extends('layouts.material')
 
@section('content')
<div class="row" style="padding-top: 6%;">

</div>


<form style='text-align:center; '>
     
     <fieldset  style='text-align:center; min-width:300px;  display:inline-block; width:35%; vertical-align:top;'>  
        Data
        <label style='padding:15px'> 
            Inicio
                <input style="width: 157px;" class='form-control' type="date" id="start" name="trip-start">
        </label>

        <label style='padding:15px'> 
            Fim
                <input style="width: 157px;" class='form-control' type="date" id="end" name="trip-start">
        </label>
            
    <div style = "font-size: 20px;">
        Unidade
        <div class="form-group" style="padding-left: 15px;padding-right: 15px;">
            <select id="unidade" onchange="dropEsp(this.value)" class="form-control">
                <option value="">Faça sua busca</option>
                @foreach($unidades as $unidade)
                    <option value="{{$unidade->unidade_saude}}">{{$unidade->unidade_saude}}</option>
                @endforeach
            </select>
        </div>
    </div>
    </fieldset>


    <fieldset style='display:inline-block; min-width:300px; width:35%; vertical-align:top; display:none;' class='secundary'>
        <div style = "font-size: 20px;">
            Especialização

            <div class="form-group" style="padding-left: 15px;padding-right: 15px;">
                <select id="especializacao" class="form-control" onchange="dropTipo(this.value)" >
                    <option value="">Faça sua busca</option>
                </select>
            </div>
        </div>

       <div style = "font-size: 20px;">
            Tipo de Consulta

            <div class="form-group" style="padding-left: 15px;padding-right: 15px;">
                <select id="tipo_consulta" class="form-control" {{--onchange="CriarQuery()"--}} >
                    <option value="">Faça sua busca</option>
                </select>
            </div>
        </div>
    </fieldset>


</form>

    <div class="row">
        <div style="padding-left: 47%;">
            <button type="submit" class='btn btn-success' id="procurar">Buscar</button>
        </div>
    </div>
    <div id="resp" class='alert'></div>

    {{-- <div id='resposta'></div> --}}
    

    <div style="min-width:300px; width: 30%; margin:5px auto; display:inline-block; vertical-align:top;">
        <canvas id="myChart" width="400" height="400"></canvas>
    </div>
    <div style='display:inline-block;vertical-align:top;'>
        <div id="efetivada" class='rounded' style='padding:5px; color:#777; font-size:12pt; background-color:rgba(54, 162, 235,.4)'></div><br>    
        <div id="emaberto" class='rounded' style='padding:5px; color:#777; font-size:12pt; background-color:rgba(255, 99, 132,.4)'></div>
    </div>


<script>
    $(document).ready(function() {
        $("button#procurar").click(function(event) {
            event.preventDefault();
            $('#resp').html("");
            $('#efetivada').html('');
            $('#emaberto').html('');
            
            let a = document.getElementById("unidade").value;
            if(a=='') $("#unidade").addClass('is-invalid');
            else $("#unidade").removeClass('is-invalid');

            let b = document.getElementById("especializacao").value;

            let c = document.getElementById("start").value;
            let d = document.getElementById("end").value;
            if(c=='' || d=='') {
                $("#start").addClass('is-invalid');
                $("#end").addClass('is-invalid');
                return false;
            } else {
                $("#start").removeClass('is-invalid');
                $("#end").removeClass('is-invalid');
            }

            let e = document.getElementById("tipo_consulta").value;



            var query = "http://consulta.test/refreshsematt/" +a+"/"+b+"/"+c+"/"+d+"/"+e;

            if(e=="" && b=="")      var query = "http://consulta.test/refreshsematt/" +a+"/"+c+"/"+d;
            else if(e=="")          var query = "http://consulta.test/refreshsematt/" +a+"/"+b+"/"+c+"/"+d;
            //console.log(query);


            $.ajax({
                url: query,
                success: function(data){
                    
                    var button = document.getElementById("procurar");
                        procurar.addEventListener("click", function(){
                            myChart.destroy();
                    });

                    var teste1 = data;
                    //console.log(teste1);
                    

                    if(teste1[0]==0 && teste1[1]==0){
                        $("#resp").html("<h3>Nenhum dado encontrado</h3>");
                    }
                    else{     
                        $('html,body').animate({
                            scrollTop:300,
                        },500);
                        var perc_efe=(teste1[0]/(teste1[0]+teste1[1])*100);
                        var perc_efe=Math.round(perc_efe);
                        var perc_abe=100-perc_efe;

                        $('#efetivada').html("Efetivadas: "+teste1[0]+" - "+perc_efe+"%");
                        $('#emaberto').html("Em aberto: "+teste1[1]+" - "+perc_abe+"%");
                        var ctx = document.getElementById('myChart');
                        var myChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: ['EFETIVADA', 'EM ABERTO'],
                                datasets: [{
                                    data: teste1,
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 99, 132, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 99, 132, 1)',
                                    ],
                                    borderWidth: 1
                                }]
                            }
                        });
                    }


                }
            })
        });
    })


    var dropEsp = function(unidade){
        if(screen.width>660){  
            $(".secundary").fadeIn(500).css('display','inline-block');
        }
        else{
            $(".secundary").fadeIn(500);
        }
        $('#especializacao').html("<option value=''>Todos</option>");
        $('#tipo_consulta').html("<option value=''>Selecione Especialização (opcional)</option>");
        $.ajax({
            url:"/especializacoes/"+unidade,
            success:function(data){
                $.each(data,function(key,value){
                    $('#especializacao').append("<option value='"+value.ocupacao+"'>"+value.ocupacao+"</option>");

                });
            }
        });
    }

    var dropTipo = function(esp){
        $('#tipo_consulta').html("<option value=''>Todos</option>");
        $.ajax({
            url:"/tipoconsulta/"+esp,
            success:function(data){
                
                $.each(data,function(key,value){
                    $('#tipo_consulta').append("<option value='"+value.tipo_consulta+"'>"+value.tipo_consulta+"</option>");

                });
            }
        });
    }
</script>

{{-- <div style="width: 350px;">
    <canvas id="myChart" width="400" height="400"></canvas>
</div> --}}




@endsection

