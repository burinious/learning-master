$("#photo").change(function() {
    $("#preview_div").show('fast');
    previewImage(this);
});

$('.all_questions_div').addClass('hide');
$('#question_div'+1).removeClass('hide');

$('.next').click(function()
{
    var current_num = parseInt($(this).attr('id'));     
    var next_num = current_num+1;
    $('#question_div'+current_num).addClass('hide');
    $('#question_div'+next_num).removeClass('hide');
});

$('.previous').click(function()
{
    var current_num = parseInt($(this).attr('id'));     
    var prev_num = current_num-1;
    $('#question_div'+current_num).addClass('hide');
    $('#question_div'+prev_num).removeClass('hide');
});

Print = (div) => {
    var details = document.getElementById(div).innerHTML;
    document.body.innerHTML = details;
    window.print();
}

NextBtn = (current_div,next_div) => {
    $(current_div).hide("fast");
    $(next_div).show("fast");
}

PrevBtn = (current_div,prev_div) => {
    $(current_div).hide("fast");
    $(prev_div).show("fast");
}

isCharNumber = (evt) => {
    var charCode = (evt.which) ? evt.which : event.keyCode;
        
    if (charCode > 31 && (charCode < 48 || charCode > 57) )
    { 
      return false;
    }
}

previewImage = (input) => {
    if(input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#preview_pix").attr('src',e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

ajaxFormRequest = (btn_id,form,url,data_type,the_status,btn_title,file_upload) => {
    var btn = $(btn_id);
    var status = $(the_status);
    btn.attr("disabled",true);
    btn.html("Please wait ...");

    if(file_upload == "no") {
        var data = $(form).serialize();
        if(data_type == "POST") {
                        
            $.ajax(
            {
                type: data_type,
                url: url,
                data: data,
                
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(msg) {
                    status.fadeIn("fast");
                    status.html(msg);
                    btn.attr("disabled",false);
                    btn.html(btn_title);
                },
                error: function(the_error) {
                    btn.attr("disabled",false);
                    btn.html(btn_title);
                    status.fadeIn("fast");
                    status.html("<p style='color:red'>Unable to perform operation</p>");
                }
            });
        } else if(data_type == "GET") {
            alert(data_type);
            $.ajax(
            {
                type: data_type,
                url: url,
                
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(msg) {
                    status.fadeIn("fast");
                    status.html(msg);
                    btn.attr("disabled",false);
                    btn.html(btn_title);
                },
                error: function(the_error) {
                    btn.attr("disabled",false);
                    btn.html(btn_title);
                    status.fadeIn("fast");
                    status.html("<p style='color:red'>Unable to perform operation</p>");
                }
            });
        }
    } else if(file_upload == "yes") {
        
        var data = new FormData($(form)[0]);
        
        $.ajax(
        {
            type: data_type,
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,

            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
                btn.attr("disabled",false);
                btn.html(btn_title);
            },
            error: function(the_error) {
                btn.attr("disabled",false);
                btn.html(btn_title);
                status.fadeIn("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    }
}

ajaxBtnRequest = (btn_id,url,the_status,btn_title,prompt,prompt_qst,status=null) => {

    if(prompt == "yes") {
        var check = window.confirm(prompt_qst);
        
        if(check) {
            var btn = $(btn_id);
            var status = $(the_status);
            btn.attr("disabled",true);
            btn.html("Please wait ...");

            $.ajax(
            {
                type: 'GET',
                url: url,
                
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(msg) {
                    status.fadeIn("fast");
                    status.html(msg);
                    btn.attr("disabled",false);
                    btn.html(btn_title);
                },
                error: function(the_error) {
                    btn.attr("disabled",false);
                    btn.html(btn_title);
                    status.fadeIn("fast");
                    status.html("<p style='color:red'>Unable to perform operation</p>");
                }
            });
        } else {
            return false;
        }
    } else {

        var btn = $(btn_id);
        var status = $(the_status);
        btn.attr("disabled",true);
        btn.html("Please wait ...");

        $.ajax(
        {
            type: 'GET',
            url: url,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
                btn.attr("disabled",false);
                btn.html(btn_title);
            },
            error: function(the_error) {
                btn.attr("disabled",false);
                btn.html(btn_title);
                status.fadeIn("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    }
}

ajaxRequest = (url,the_status,type) => {
    
    if(type == "GET") {
        var status = $(the_status);
        status.html("Please wait ....");

        $.ajax(
        {
            type: type,
            url: url,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    }
}

ajaxLoadingRequest = (url,the_status,data,type) => {
    
    if(type == "GET") {
        var status = $(the_status);
        status.html("<svg class='circular' viewBox='25 25 50 50'><circle class='path' cx='50' cy='50' r='20' fill='none' stroke-width='2' stroke-miterlimit='10' /> </svg>");

        $.ajax(
        {
            type: type,
            url: url,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    } 
    else if(type == "POST") {
        var status = $(the_status);
        status.html("<svg class='circular' viewBox='25 25 50 50'><circle class='path' cx='50' cy='50'   r='20' fill='none' stroke-width='2' stroke-miterlimit='10' /> </svg>");
        
        $.ajax(
        {
            type: type,
            url: url,
            data: data,
            cache: false,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    }
}

ajaxChatLoadingRequest = (url,the_status,data,type) => {
    
    if(type == "GET") {
        var status = $(the_status);
        status.html("Please wait..");

        $.ajax(
        {
            type: type,
            url: url,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    } 
    else if(type == "POST") {
        var status = $(the_status);
        status.html("<svg class='circular' viewBox='25 25 50 50'><circle class='path' cx='50' cy='50'   r='20' fill='none' stroke-width='2' stroke-miterlimit='10' /> </svg>");
        
        $.ajax(
        {
            type: type,
            url: url,
            data: data,
            cache: false,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    }
}

ajaxChatRequest = (url,the_status,data,type) => {
    
    if(type == "GET") {
        var status = $(the_status);
        status.html("<svg class='circular' viewBox='25 25 50 50'><circle class='path' cx='50' cy='50' r='20' fill='none' stroke-width='2' stroke-miterlimit='10' /> </svg>");

        $.ajax(
        {
            type: type,
            url: url,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
                $("#chat_list").scrollTop($("#chat_list")[0].scrollHeight);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    } 
    else if(type == "POST") {
        var status = $(the_status);
        status.html("<svg class='circular' viewBox='25 25 50 50'><circle class='path' cx='50' cy='50'   r='20' fill='none' stroke-width='2' stroke-miterlimit='10' /> </svg>");
        
        $.ajax(
        {
            type: type,
            url: url,
            data: data,
            cache: false,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.fadeIn("fast");
                status.html(msg);
                $("#chat_list").scrollTop($("#chat_list")[0].scrollHeight);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    }
}

ajaxNoLoadingRequest = (url,the_status,data,type,show) => {
    var status = $(the_status);
    var refresh = $("#refresh_div");
    
    (show == "yes") ? refresh.show("fast") : "";

    if(type == "GET") {
        
        $.ajax(
        {
            type: type,
            url: url,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.html(msg);
                refresh.hide("fast");
                $("#chat_list").scrollTop($("#chat_list")[0].scrollHeight);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                refresh.hide("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
            }
        });
    } 
    else if(type == "POST") {
        
        $.ajax(
        {
            type: type,
            url: url,
            data: data,
            cache: false,
            
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(msg) {
                status.html(msg);
                refresh.hide("fast");
                $("#chat_list").scrollTop($("#chat_list")[0].scrollHeight);
            },
            error: function(the_error) {
                status.fadeIn("fast");
                status.html("<p style='color:red'>Unable to perform operation</p>");
                refresh.hide("fast");
            }
        });
    }
}

checkGroupDetails = () => {
    var group_name = $("#group_name").val();
    var group_desc = $("#group_desc").val();
    var status = $("#phase_one_status");

    if(group_name == "" || group_desc == "") {
        status.html("<p class='text-danger' align='center'>Please fill both fields. </p>");
    } else {
        status.html("");
        $("#phase_one").fadeOut(500);
        $("#phase_two").show().fadeIn(2000);
        ajaxRequest("/students/all-users","#all_users_div","GET");
    }
}

checkTutorGroupDetails = () => {
    var group_name = $("#group_name").val();
    var group_desc = $("#group_desc").val();
    var status = $("#phase_one_status");

    if(group_name == "" || group_desc == "") {
        status.html("<p class='text-danger' align='center'>Please fill both fields. </p>");
    } else {
        status.html("");
        $("#phase_one").fadeOut(500);
        $("#phase_two").show().fadeIn(2000);
        ajaxRequest("/tutors/all-users","#all_users_div","GET");
    }
}

searchStudentGroups = () => {
    var group = $("#group").val();
    var status = $("#search_div");
    
    if(group.trim() == ""){
        document.getElementById("real_div").style.display = "block";
        document.getElementById("search_div").style.display = "none";
        return false;
    } else {
        document.getElementById("real_div").style.display = "none";
        document.getElementById("search_div").style.display = "block";
        ajaxLoadingRequest("/students/search-group/"+group,status,"","GET");
    }
}

searchItem = (item,status,real_div,search_div,url) => {
    var the_item = $(item).val();
    var the_status = $(status);
    
    if(the_item.trim() == "") {
        document.getElementById(real_div).style.display = "block";
        document.getElementById(search_div).style.display = "none";
        return false;
    } else {
        document.getElementById(real_div).style.display = "none";
        document.getElementById(search_div).style.display = "block";
        ajaxLoadingRequest(url+"/"+the_item,the_status,"","GET");
    }
}