$(()=>{
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#pp').change(()=>{
        let fd= new FormData();
        let file=$('#pp')[0].files[0]; 
        fd.append("profile_picture",file);
        $.ajax({
            url: "Update_Profile",
            method: "POST",
            data: fd,
            contentType:false,
            cache:false,
            processData:false,
            success:(data)=>{
                $("#profile_picture").attr('src',data);
            }
        })
    });
    $('#submit').click((e)=>{
        e.preventDefault();
        if($('#country').val()!="" || $('#tel').val()!=""){
            $("#spinner").addClass("spinner-border spinner-border-sm");
            $.ajax({
                url:'/Update_Profile',
                method:"POST",
                data: {
                    country:$('#country').val() ?? "",
                    tel:$('#tel').val() ?? ""
                },
                success:(data)=>{
                    $("#spinner").removeClass("spinner-border spinner-border-sm");
                    $("#spinner").next().text("Done!");
                    $("#spinner").parent().removeClass("btn-primary").addClass('btn-success');
                    setTimeout(()=>{
                        $("#spinner").parent().addClass("btn-primary").removeClass('btn-success');
                        $("#spinner").next().text("Submit");
                    },3000)
                }
            });
        }
    });
});