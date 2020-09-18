function baseUrl(){
    var baseUrl = ''
    if (window.location.host === 'localhost') {
        baseUrl = 'http://localhost/assessment_app'
    } else {
        baseUrl =  window.location.origin
    }

    return baseUrl
}

function showLoading(className){
    var prevHtml = $('.'+ className).html()
    $('.'+ className).text("")
    $('.'+ className).attr("disabled",true)
    $('.'+ className).html(
        '<span class="spinner-border spinner-border-sm mx-1" role="status" aria-hidden="true" ></span>' +
        'Loading...' 
    )
    return prevHtml
}

function hideLoading(className,newText){
    $('.'+ className).text(newText)
    $('.'+ className).attr("disabled",false)
}

function showLoadingOverlay(){
    $('.loading-overlay').show()
}

function hideLoadingOverlay(){
    $('.loading-overlay').hide()
}

$(document).ready(function(){
    // HIDE LOADING SCREEN
    hideLoadingOverlay()

    // PREVENT DEFAULT
    $('.prevent_default').click(function(e){
        e.preventDefault()
    })

    // AJAX BACKGROUD SUBMIT
    $('.ajax_submit').submit(function(e){
        e.preventDefault();

        prevHtml = showLoading('ajax_button')

        // postData = $(this).serialize()
        postData = new FormData(this)

        if ($('input[name="passport"]').val()){
            postData.append('passport',$('input[name="passport"]').serialize());
        }
        
        postUrl = $(this).attr('action')

        $.ajax({
            type: 'POST',
            url: postUrl,
            data: postData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function (data) {
                switch (data.result) {
                    case true:
                        if (data.message){
                            toastr.success(data.message)
                        }

                        if(data.url == 'refresh'){
                            location.reload()
                        }else if(data.url){
                            window.location.href = baseUrl() + data.url
                        }
                        hideLoading('ajax_button',prevHtml)
                        break
                        
                    case 'error':
                        hideLoading('ajax_button',prevHtml)
                        for(key in data.error){
                            var val = data.error[key]
                            toastr.error(val)
                        }
                        break
                    case 'message':
                        hideLoading('ajax_button',prevHtml)
                        toastr.error(data.error)
                        break
                    
                    case 'success':
                        toastr.success(data.message)
                        window.location.href = baseUrl() + data.url
                        break
                }
            }
        });
    })

    // FACULTY & DEPARTMENT DROPDOWN
    $('#faculty').change(function (e) { 
        e.preventDefault();
        var facultyId = $(this).val()
        $.getJSON( baseUrl() + "/auth/get_department/" + facultyId,
            function (data) {
                var option = []

                for(var key in data.department){ 
                    var value = data.department[key]
                    option += value
                } 
                
                var dept_list = '<select name="department> class="form-control>' + option + '</select>'
                
                $('#department').html(dept_list)
            }
        )
    })

    // CREATE ASSESSMENT
    $('.create_assessment').click(function(evt){

        showLoadingOverlay()

        function checkQuestionType(){
            var url = $('#type_form').attr('action')
            var postDataFirst = $('#type_form').serialize()

            $.post(url, postDataFirst, 
                function (o) { 
                    hideLoadingOverlay()
                    if (o.result == 1){
                        
                        // CHECK IF IT IS OBJ OR ESSAY
                        if(o.question_type == 1){
                            // OBJ
                            var totalMarkInput = '<input type="number" name="total_mark" placeholder="Total mark" class="name form-control" required/>'
                        }else{
                            // ESSAY
                            var totalMarkInput = '<input type="hidden"/>'
                        }
                        //  END

                        if (o.type == 1){
                            var typeName = 'Duration'
                            var type = 'number'
                            var name = 'duration'
                            var value = 0
                            var label = 'minutes'
                        }else if (o.type == 2){
                            var typeName = 'Deadline'
                            var type = 'date'
                            var name = 'deadline'
                            var value = '2019-02-03'
                            var label = ''
                        }

                        var assignmentSecondaryForm = '<form action="'+ baseUrl() + '/public/assessment/create' + '" class="formName" id="type">' +
                        '<div class= "form-group">' +
                            '<label>'+label+'</label><br>' +
                            '<input type="' + type + '" name="type_input" placeholder="" value="' + value + '" class="name form-control"/>' +  
                            '<input type="hidden" name="mytype" value="'+ type +'">' +   
                        '</div>' +                        
                        totalMarkInput +
                        '</form>'

                        $.confirm({
                            title: typeName,
                            content: '' + assignmentSecondaryForm,
                            type: 'blue',
                            typeAnimated: true,
                            buttons: {
                                close: {

                                },
                                formSubmit: {
                                    text: 'Next',
                                    btnClass: 'btn-blue',
                                    action: function () { 
                                        createQuestion(postDataFirst) 
                                        showLoadingOverlay()
                                        return false
                                    } 
                                }
                                
                            }
                        })
                    }else{
                        for(key in o.error){
                            var val = o.error[key]
                            toastr.error(val)
                        }
                    }
            },'json')
        }

        function createQuestion(postDataFirst){
            var url = $('#type').attr('action')
            var postDataSecond = $('#type').serialize()
            var postData = postDataFirst + '&' + postDataSecond

            $.post(url, postData,
                function (o) {
                    hideLoadingOverlay()

                    if (o.result == 1){
                        showLoadingOverlay()
                        toastr.success('Assessment has been created sucessfull')
                        window.location.href = baseUrl() + '/public/assessment/view/' + o.ast_id;
                    }else{
                        for(var key in o.error){
                            var value = o.error[key]
                            toastr.error(value)
                        }
                    }
                },'json'
            )
        }

        evt.preventDefault();
        $.getJSON( baseUrl() + "/public/course_reg/get_course",
        function(o){
            hideLoadingOverlay()
            option = []

            for (var i = 0; i < o.course.length; i++) {
                var value = o.course[i];
                option += '<option value="' + value.courseId + '" >' + value.courseCode + '</option>'
            }
            var assignmentForm = '<form action="' + baseUrl() + '/public/assessment/check_assessment"  class="formName" id="type_form">' +
            '<div class= "form-group">' +
                '<label>Assessment Name</label><br>' +
                '<input type="text" name="assessment_name" placeholder="" class="name form-control" required />' +       
            '</div>' +
            '<div class= "form-group">' +
                '<label>Course Code</label><br>' +    
                '<select name="assessment_course" class="form-control">' +
                   option +
                '</select>'+
            '</div>' +
            '<div class="form-group">'+
                '<label>Assessment type</label><br>'+
                '<select name="assessment_type" class="form-control" >'+
                    '<option value="1">Live</option>'+
                    '<option value="2">Deadline</option>'+
                '</select>'+
            '</div>' +
            '<div class="form-group">'+
                '<label>Question type</label><br>'+
                '<select name="question_type" class="form-control" >'+
                    '<option value ="1">Objectives</option>'+
                    '<option value ="2">Eassy</option>'+
                '</select>'+
            '</div>' +
            '</form>'

            $.confirm({
                title: 'Create',
                type: 'blue',
                content: '' + assignmentForm,
                typeAnimated: false,
                buttons: {
                    close: {
                        action: hideLoadingOverlay()
                    },
                    formSubmit: {
                        text: 'Next',
                        btnClass: 'btn-blue',
                        action: function () { 
                            checkQuestionType() 
                            showLoadingOverlay()
                            return false
                        }
                    }
                }
            })
        })
    })

    $('#new-assessment-label').hide()

    $.getJSON( baseUrl() + "/public/evaluation/index/1", null,
        function (o) {
            if(o.result){
                $('#new-assessment-label').show()
            }
            $('#new-assessment-count').text(o.count)
        }
    );
})

// SEND ASSESSMENT
function send_assessment(assessment_id) { 

    $.confirm({
        title: 'Send',
        content: 'Do you want to send this assessment to your students?',
        type: 'green',
        typeAnimated: true,
        buttons:{
            confirm: function (){
                var badgeId = '#assessment-badge-'+ assessment_id
                var buttonClass = '.assessment-button-'+ assessment_id
                var url = baseUrl() + '/public/assessment/send/' + assessment_id;

                $(badgeId).attr('class','badge badge-info');
                $(badgeId).text('Sending...');

                $.getJSON(url, function (output) {
                        if (output.result == 1){
                            $(badgeId).attr('class','badge badge-primary');
                            $(buttonClass).attr('disabled','disabled');
                            $(badgeId).text('Sent');
                            toastr.success('Assessment Sent!')
                        }else{
                            toastr.error('Unable to send assessment!')
                            $(badgeId).attr('class','badge badge-success');
                            $(badgeId).text('Send');
                        }
                    }
                );
            },
            close: function (){
                
            }                                    
        }  
    });
};

function get_question(type,question_id,assessment_id = null){
    $('#question_go_back_btn').show()
    showLoadingOverlay()

    var url = baseUrl() + '/public/assessment/get_question/' + type + '/' + question_id
    var url_update = baseUrl() + '/public/assessment/update_question/' + type + '/' + question_id + '/' + assessment_id
    $('#form_question_add').attr('action',url_update)
    $('#add_question').text('Edit')

    switch (type) {
        case 1:
            // OBJ
            $.getJSON(url, function(output){
                $('input[name="obj_question"]').val(output.question)
                $('input[name="obj_a"]').val(output.option_A)
                $('input[name="obj_b"]').val(output.option_B)
                $('input[name="obj_c"]').val(output.option_C)
                $('input[name="obj_d"]').val(output.option_D)

                $('input[value="' + output.answer + '"]').prop('checked',true)

                hideLoadingOverlay()
            });
            break

        case 2:
            // ESSAY
            $.getJSON(url, function(output){
                $('textarea[name="essay_question"]').val(output.question)
                $('input[name="essay_mark"]').val(output.mark)

                hideLoadingOverlay()
            });
            break
    
        default:
            break
    }
}

function current_link(id) {
    $('[id ^= "link"]').attr('class','btn btn-primary btn-flat').css('color','white');
    $(id).attr('class','btn btn-default btn-flat').css('color','black');
}

function send_message(user_id){
    $.confirm({
        title: 'Message',
        type: 'blue',
        content: '' +
        '<form action="' + baseUrl() + '/public/messaging/send/' + user_id + '" class="ajax_submit" id="message_form" method="post">' +
            '<div class="form-group">' +
                '<label>Your Message</label>' +
                '<textarea name="message" type="text" placeholder="Your Message" class="form-control" row="3" required />' +
            '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Send',
                btnClass: 'btn-blue',
                action: function () {
                    showLoadingOverlay()
                    message_url = $('#message_form').attr('action')
                    data = $('#message_form').serialize()

                    $.post(message_url, data,
                        function (o) {
                            hideLoadingOverlay()
                            if (o.result == 1){
                                toastr.success('Message Sent!')
                                window.location.href= baseUrl() + "/public/messaging/open/" + user_id
                            }else{
                                for(key in o.error){
                                    var val = o.error[key]
                                    toastr.error(val)
                                }
                            }
                        },
                        "json"
                    );
                    return false
                }
            },
            cancel: function () {
                
            },
        }
    });
}

function get_question_ans(type,question_id,assessment_id){
    $('#question_go_back_btn').show()
    showLoadingOverlay()

    $('input[name="answer"]').prop('checked',false)

    var url = baseUrl() + '/public/evaluation/get_question/' + type + '/' + question_id + '/' + assessment_id
    var url_submit = baseUrl() + '/public/evaluation/answer/' + type + '/' + question_id + '/' + assessment_id

    $('#form_evaluation_submit').attr('action',url_submit)

    switch (type) {
        case 1:
            // OBJ
            $.getJSON(url, function(output){
                $('#obj_question').text(output.question)
                $('#obj_a').text(output.option_A)
                $('#obj_b').text(output.option_B)
                $('#obj_c').text(output.option_C)
                $('#obj_d').text(output.option_D)

                $('#ans_a').val(output.option_A)
                $('#ans_b').val(output.option_B)
                $('#ans_c').val(output.option_C)
                $('#ans_d').val(output.option_D)

                // Get answer
                var answerInput = 'input[value="' + output.answer + '"]'
                $(answerInput).prop('checked',true)

                hideLoadingOverlay()
            });
            break

        case 2:
            // ESSAY
            $.getJSON(url, function(output){
                $('#essay_question').text(output.question + ' (' + output.mark + 'marks)' )

                // Get answer
                $('textarea[name="answer"]').val('' + output.answer + '')

                hideLoadingOverlay()
            })
            break
    
        default:
            break
    }

}

function submit_answer(){
    // TO SUBMIT ANSWER
    // ALSO CALLED FROM MARK VIEW
    var url = $('#form_evaluation_submit').attr('action')
    var postData = $('#form_evaluation_submit').serialize()

    $.post(url, postData, function(o){
        console.log(o)
    },
    "json")
    // TO SUBMIT ANSWER END
    return true
}

function submit_final(assessment_id){

    url = baseUrl() + '/public/evaluation/submit/' + assessment_id

    $.post(url, function(o){
        if(o.result == 1){
            window.location.href = baseUrl()
        }
    },"json"
    )

}

function startTime() {
    var today = new Date()
    var h = today.getHours()
    var m = today.getMinutes()
    var s = today.getSeconds()
    m = checkTime(m)
    s = checkTime(s)
    document.getElementById('txt').innerHTML =
    h + ":" + m + ":" + s
    var t = setTimeout(startTime, 500)
}

function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10

    return i
}

function get_mark_question(assessment_id,user_id,question_id){
    showLoadingOverlay()

    var url = baseUrl() + '/public/assessment/get_mark_question/' + assessment_id + '/' + user_id + '/' + question_id
    var url_submit = baseUrl() + '/public/assessment/submit_score/' + assessment_id + '/' + user_id + '/' + question_id

    $('#form_evaluation_submit').attr('action',url_submit)
     
    // ESSAY
    $.getJSON(url, function(output){
        $('#student_question').text(output.question + '(' + output.mark + 'marks)')
        $('#student_answer').text(output.answer)
        $('#current_mark').text(output.current_mark)

        $('#essay_answer_mark').val(output.score)

        hideLoadingOverlay()
    });
           
}