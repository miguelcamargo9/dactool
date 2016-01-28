<html>
    <head>
        <link href="packages/css/mailtemplate.css" rel="stylesheet">
        <title>Mail Template</title>
    </head>
    <body>
        <div class="container">
            <div class="CSS_Texto">
                <h3>Cordial Saludo: Miguel Camargo</h3>
                <p>Las descripciones de las Interfaces no se encuentran estandarizadas de acuerdo a la siguiente directiva:</p>
                <p><b>BACKBONE o INTERPOP #- TO_NombreDelEquipoDeRed [Interfaz] - direccion IP #- ENCAPSULATION:Tipo #</b>.</p>
            </div>
            <div class="CSS_Table_Example" style="width:60%;">
                <table>
                    <tr> 
                        <th> <b> NOMBRE </b> </th> 
                        <th> <b> DIRECCION IP </b> </th> 
                        <th> <b> CONF </b> </th>
                    </tr>
                    <tr>
                        <td>{{$name}}</td>
                        <td>{{$ip}}</td>
                        <td>{{$conf}}</td>
                    </tr>
                </table>
            </div>
            <div class="CSS_Texto"><br><br>Cordialmente<br>
                <img src='packages/images/dactool_logo.png' alt='Dactool Logo'/>
                <br>Script Automatico<br>(200.62.3.11:/usr/local/scripts/mcamargo/prueba.php)
                <br>(Tomando como base la informacion generada por 200.62.3.11:/usr/local/scripts/get_info_routers.pl)<br>
            </div>
        </div>
    </body>
</html>
