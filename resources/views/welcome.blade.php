@extends('layouts.material')

@section('content')
<div class="row" style="padding-top: 6%;">

</div>
<div class="row">
    <div style = "width: 32%;font-size: 20px; margin:-35px auto;">
        Data
        <div class="row" style="margin-right: 0px;margin-left: 0px;">
            <div style="width: 49.9%;">
                Inicio
            </div>
            <div style="padding-left: 53px;">
                Fim
            </div>
        </div>
        <div class="row" style="margin-right: 0px;margin-left: 0px;">
            <div style="width: 49.9%;">
                <input style="font-size: smaller;width: 157px;" class='form-control' type="date" id="start" name="trip-start">
            </div>
            <div>
                <input style="font-size: smaller;width: 157px;" class='form-control' type="date" id="end" name="trip-start">
            </div>
        </div>
    </div>

    <div style = "width: 32%;font-size: 20px;">
        Unidade
        <div class="form-group" style="padding-left: 15px;padding-right: 15px;">
            <select id="unidade" class="form-control" {{-- onchange="CriarQuery()"--}} >
                <option value="">Faça sua busca</option>
                @foreach($unidades as $unidade)
                    <option value="{{$unidade->unidade_saude}}">{{$unidade->unidade_saude}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div style = "width: 32%;font-size: 20px;">
        Especialização
        <div class="form-group" style="padding-left: 15px;padding-right: 15px;">
            <select id="especializacao" class="form-control" {{--onchange="CriarQuery()"--}} >
                <option value="">Faça sua busca</option>
                @foreach($especializacoes as $especializacao)
                    <option value="{{$especializacao->ocupacao}}">{{$especializacao->ocupacao}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

    <div class="row">
        <div style="padding-left: 50%;">
            <button type="submit" id="procurar">Buscar</button>
        </div>
    </div>

    {{-- <div id='resposta'></div> --}}
    
    <div class="row" style='text-align:center;'>
        <div style="width: 30%; margin:5px auto;">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
    </div> 

<script>
    $(document).ready(function() {
        $("button#procurar").click(function() {
            let a = document.getElementById("unidade").value;
            // console.log(a);
            let b = document.getElementById("especializacao").value;
            //console.log(b);
            let c = document.getElementById("start").value;
            console.log(c);
            let d = document.getElementById("end").value;
            console.log(d);

            $.ajax({
                url: "http://consulta.test/refreshsematt/" +a+"/"+b+"/"+c+"/"+d,
                success: function(data){
                    
                    var button = document.getElementById("procurar");
                        procurar.addEventListener("click", function(){
                            myChart.destroy();
                    });

                    var teste1 = data;
                    console.log(teste1);
            
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
            })
        });
    })
</script>

{{-- <div style="width: 350px;">
    <canvas id="myChart" width="400" height="400"></canvas>
</div> --}}




@endsection

