$('document').ready( function()
{
    $('table').on('click', 'a.destroyData', function(ele){
        ele.preventDefault();

        var urlDestroy = $(this).attr('href');
        var tr = ele.target.parentNode;
        var token = $(this).data("token");

        $.ajax(
            urlDestroy,
            {
                method: 'DELETE',
                data: {
                    //"_method": 'DELETE',
                    //"_token": token,
                    "_token": '{{csrf_token()}}',
                },
                complete: function(resp){
                    console.log(resp);
                    alert(resp.responseText);
                    
                    if(resp.responseText==1){
                        tr.parentNode.removeChild(tr);
                    }else{
                        //alert('Errore nella cancellazione del record');
                        toastr.error('Errore nella cancellazione del record', 'Ops! Qualcosa non ha funzionato!')
                    }
                }
            }
        )

    })
})
