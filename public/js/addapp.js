$("#csvfile").on("change", (e)=>{
    if($('#csvfile')[0].files.length==1){
        $('#uploadbtn').addClass("btn-success").removeClass("btn-primary").html($('#csvfile')[0].files[0].name);
        console.log("a file is selected");
    }else{
        $('#uploadbtn').addClass("btn-primary").removeClass("btn-success").html("Upload a CSV file");
        console.log("nothing is selected");
    }
})