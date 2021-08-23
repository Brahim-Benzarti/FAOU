var events=["Interview","Flag","Incomplete","Reject","star1","star2","star3","star4","star5"];
var stars=["star1","star2","star3","star4","star5"];
$(()=>{
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
    stars.forEach(star => {
        $("#"+star).on("mouseover click",()=>{
            $("#"+star).prevAll().css("opacity",'1');
            $("#"+star).css("opacity",'1');
        })
        $("#"+star).mouseleave(()=>{
            $("#"+star).prevAll().css("opacity",'0.3');
            $("#"+star).css("opacity",'0.3');
        })
    });
})