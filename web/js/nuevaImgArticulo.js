var tiposValidos=
[
    'image/jpeg',
    'image/png',
    'image/jpg'
];

function validarTipos(file)
{
    for(var i=0; i<tiposValidos.length; i++)
    {
        if (file.type===tiposValidos[i])
        {
            return true;
        }
    }
    return false;
}

function onChange(event)
{
     var file=event.target.files[0];
     if(validarTipos(file))
     {
         var articuloMiniatura=document.getElementById(articuloThumb);
         articuloThumb.src=window.URL.createObjectURL(file);

     }
}