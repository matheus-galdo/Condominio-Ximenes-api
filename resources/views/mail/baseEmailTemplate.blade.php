<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Email Template</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

</head>

<body style="border: 0; margin: 0; padding: 20px 5% 60px 5%; box-sizing: border-box; background-color: #e7e7e7;
font-family: Roboto, Arial, Helvetica, sans-serif;">
    <div style="background-color: #fff; border-radius: 5px;">
        <table width='100%' style="background-color: #2e98fb; border-radius: 5px 5px 0px 0px;">
            <tbody>
                <tr>
                    <td height="10px"></td>
                </tr>
                <tr>
                    <td style="padding: 0px 50px;">Condominio Ximenes 2</td>
                </tr>
                <tr>
                    <td height="20px"></td>
                </tr>
                <tr>
                    <td align="center">
                        <img src="{{ $img }}" width="150" height="150"/>
                    </td>
                </tr>
                <tr>
                    <td height="10px"></td>
                </tr>
                <tr>
                    <td style="text-align:center; color: #fff; padding:0 50px; font-size: 20pt; font-weight: 500;">{{ $titulo }}</td>
                </tr>
                <tr>
                    <td height="20px"></td>
                </tr>
                <tr>
                    <td style="text-align:center; color: #fff; padding:0 50px;" height="20px">{{ $today }}</td>
                </tr>
                <tr>
                    <td height="20px"></td>
                </tr>
            </tbody>
        </table>
        <div style="padding: 50px 50px;">
            <h1 style="font-size: 16pt;">Olá {{ $nome }},</h1>
            <div style="font-size: 13pt; color: #6e6e6e;">
                
                @yield('content')
                
            </div>
        </div>
    </div>
    <div style="color: #6e6e6e;">
        <p>Você esta recebendo este e-mail porque alugou um apartamento em nosso condomínio.</p>
        <p>Clique <a href="{{ $unsubscribeUrl }}" alt='Desescrever'>aqui</a> se não quiser receber mais nenhum e-mail.</p>
    </div>
</body>

</html>