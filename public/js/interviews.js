$(()=>{
    // $.post(
    //     '/mail',
    //     {
    //         "_token":$("meta[name='csrf-token']").attr("content")
    //     },
    //     (data,stat)=>{
    //         $('#mail').html(data);
    //     }
    // );
    $("#number").change(()=>{
        $.post(
            '/peoplelist',
            {
                "_token":$("meta[name='csrf-token']").attr("content"),
                "number":$("#number").val()
            },
            (data,stat)=>{
                $('#people').html(data);
            }
        );
    });
    $("#send").click(()=>{
        console.log($("#copy").prop("checked"));
        $.post(
            '/email/interview',
            {
                "_token":$("meta[name='csrf-token']").attr("content"),
                "number":$("#number").val(),
                "link":$("#link").val(),
                "me":$("#copy").prop("checked")
            },
            (data,stat)=>{
                console.log(data);
            }
        );
    });
});