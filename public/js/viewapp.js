var formfields=["status","decision","flag"];
var events=["Read","Interview","Flag","Incomplete","Reject"];
$(()=>{
    formfields.forEach(e => {
        $("#"+e).change(()=>{
            console.log("submit");
            $("#myform").submit()
        });
    });
    
    var id=$("#id").attr('content');
    events.forEach(event => {
        $('#'+event).click(()=>{
            $('#'+event).children().first().addClass("spinner-border spinner-border-sm");
            $.post(
                "/View_Application/"+id,
                {
                    "_token":$("meta[name='csrf-token']").attr("content"),
                    "event":event
                },
                (data,status)=>{
                    console.log(data);
                    $('#'+event).children().first().removeClass("spinner-border spinner-border-sm");
                }
            ).fail((resp)=>{
                $('#'+event).children().first().addClass("spinner-border spinner-border-sm");
            })
        })
    });
})