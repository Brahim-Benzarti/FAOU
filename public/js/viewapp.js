var events=["Interview","Flag","Incomplete","Reject","star1","star2","star3","star4","star5"];
var stars=["star1","star2","star3","star4","star5"];
var defaultstars=[];
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
                    $('#'+event).children().last().text(data);
                }
            ).fail((resp)=>{
                $('#'+event).children().first().addClass("spinner-border spinner-border-sm");
            })
        })
    });

    stars.forEach(star => {
        $("#"+star).click(()=>{
            $("#"+star).prevAll().removeClass('star');
            $("#"+star).prevAll().addClass('blurstar');
            $("#"+star).nextAll().removeClass('blurstar');
            $("#"+star).nextAll().addClass('star');
            $("#"+star).addClass('star');
            $("#"+star).removeClass('blurstar');
        });
    });
})