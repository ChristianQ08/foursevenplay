$(document).ready(function(){
    
    //LISTENING SELECT REPORTS
    $('#select_reports').on('change', function(){
        let idReport = $(this).val();
        switch(idReport){
            case '1' :
                hideReport2();
                hideReport3();
                hideReport4();
                showReport1();
                break;
            case '2' :
                hideReport1();
                hideReport3();
                hideReport4();  
                showReport2();
                break;
            case '3' :
                hideReport1();
                hideReport2();
                hideReport4();
                showReport3();                
                break;
            case '4' :
                hideReport1();
                hideReport2();
                hideReport3();   
                showReport4();
                break;
            default:
                hideReport1();
                hideReport2();
                hideReport3();
                hideReport4();
                break;

        }
    });
    
    //TO DESTROY ANY DATATABLE
    function destroyDataTable( name ){
        let table = $( '#' + name ).dataTable().api();
        table.destroy();
    }

    // ------------ REPORT 1 ------------------------------
    function showReport1(){
        fillSelectUsers();
        $('#div_usersSessByUsers').attr('hidden', false);
        $('#div_SessByUsers').attr('hidden', false);
    }
    function hideReport1(){
        destroyDataTable('table_SessByUsers');
        $('#div_usersSessByUsers').attr('hidden', true);
        $('#div_SessByUsers').attr('hidden', true);
        $("#select_usersSessByUsers").empty();
    }

    //FILL SELECT USERS
    function fillSelectUsers(){
        $.getJSON('../models/Users.Model.php', function(response) {	    
            $("#select_usersSessByUsers").empty();
            $("#select_usersSessByUsers").append('<option value="0"></option>');
            for(const i in response){
                let id = response[i].id;
                let username = response[i].username;
                $("#select_usersSessByUsers").append("<option value='"+id+"'>"+username+"</option>");
            };	    
        });
    }

    //BUTTON SEARCH
    $('#searchSessByUsers').on('click', function(){
        datatableSessionsByUser();        
    });

    function datatableSessionsByUser(){        
        //IF DATATABLE EXITS RELOAD ELSE MAKE 
        if ($.fn.dataTable.isDataTable( "#table_SessByUsers" )){
            let api = $( "#table_SessByUsers" ).dataTable().api();
            api.ajax.reload();
        }
        else{
            var table = $("#table_SessByUsers")
            .DataTable({
                responsive: true,
                language: {
                    sZeroRecords: 'No results found',
                    sEmptyTable: 'No results found',
                    sInfoFiltered: '',
                    sInfoPostFix: '',
                    sInfoSelected: '',
                    sSearch: 'Search:',
                    sLoadingRecords: 'Searching...',
                    paginate: {
                        first: "<<",
                        previous: "<",
                        next: ">",
                        last: ">>"
                    },
                },
                dom: '<"dom">frtp',
                lengthChange: false,
                paging: true,            
                order: [[1, 'desc']], 
                ajax: {
                    url: "../models/SessionsByUser.Model.php",
                    data: function() {
                        return {                    
                            idUser: $('#select_usersSessByUsers').val() //---------- INPUT
                        };
                    },
                type: "POST",
                dataSrc: ""
                },
                columns: [
                    { data: 'session_id' },
                    { data: 'login_tstamp' },
                    { data: 'logout_tstamp' },
                    { data: 'ip_address' }
                ]

            });
        }
        
    }
    // ------------ END REPORT 1 ------------------------------


    // ------------ REPORT 2 ------------------------------

    function showReport2(){      
        $('#div_UserLog3PerW').attr('hidden', false);
        $('#div_dateUserLog3PerW').attr('hidden', false);
    }
    function hideReport2(){
        $('#div_dateUserLog3PerW').attr('hidden', true);
        $('#div_UserLog3PerW').attr('hidden', true);
        destroyDataTable('table_UserLog3PerW');        
    }

    $('#dateUserLog3PerW').datetimepicker({
        locale: 'es',
        format: 'YYYY/MM'
    });

    //BUTTON
    $('#searchUserLog3PerW').on('click', function(){
        if( $('#dateUserLog3PerW').val() === ''){
            alert('Please select a date first');            
        }
        else
        {
            datatableUserLog3PerW();            
        }
    });

    function datatableUserLog3PerW(){
        //IF DATATABLE EXITS RELOAD ELSE MAKE 
        if ($.fn.dataTable.isDataTable( "#table_UserLog3PerW" )){
            let api = $( "#table_UserLog3PerW" ).dataTable().api();
            api.ajax.reload();
        }
        else{
            var table = $("#table_UserLog3PerW")
            .DataTable({
                responsive: true,
                language: {
                    sZeroRecords: 'No results found',
                    sEmptyTable: 'No results found',
                    sInfoFiltered: '',
                    sInfoPostFix: '',
                    sInfoSelected: '',
                    sSearch: 'Search:',
                    sLoadingRecords: 'Searching...',
                    paginate: {
                        first: "<<",
                        previous: "<",
                        next: ">",
                        last: ">>"
                    },
                },
                dom: '<"dom">frtp',
                lengthChange: false,
                paging: true,            
                order: [[1, 'desc']],
                columnDefs: [{
                    targets: -1,
                    orderable: false,
                    responsivePriority: 1,
                    width: '10%',
                }],
                ajax: {
                    url: "../models/UserLog3PerW.Model.php",
                    data: function() {
                        return {
                             year: $('#dateUserLog3PerW').val().substring(0,4),  //---------- INPUT
                             month: $('#dateUserLog3PerW').val().substring(5,7) //---------- INPUT
                        };
                    },
                type: "POST",
                dataSrc: ""
                },
                columns: [
                    { data: 'id' },
                    { data: 'username' },
                    { data: 'user_names' }
                ]

            });
        }
        
    }
    // ------------ END REPORT 2 ------------------------------


    // ------------ REPORT 3 ------------------------------

    function showReport3(){   
        $('#div_SDurPerM').attr('hidden', false);
        $('#div_dateSDurPerM').attr('hidden', false);
    }
    function hideReport3(){
        $('#div_SDurPerM').attr('hidden', true);
        $('#div_dateSDurPerM').attr('hidden', true);
        destroyDataTable('table_SDurPerM');        
    }

    $('#dateSDurPerM').datetimepicker({
        locale: 'es',
        format: 'YYYY/MM'
    });

    //BUTTON SEARCH
    $('#searchSDurPerM').on('click', function(){
        if( $('#dateSDurPerM').val() === ''){
            alert('Please select a date first');            
        }
        else
        {
            datatableSDurPerM();            
        }
    });

    function datatableSDurPerM(){        
        //IF DATATABLE EXITS RELOAD ELSE MAKE 
        if ($.fn.dataTable.isDataTable( "#table_SDurPerM" )){
            let api = $( "#table_SDurPerM" ).dataTable().api();
            api.ajax.reload();
        }
        else{
            var table = $("#table_SDurPerM")
            .DataTable({
                responsive: true,
                language: {
                    sZeroRecords: 'No results found',
                    sEmptyTable: 'No results found',
                    sInfoFiltered: '',
                    sInfoPostFix: '',
                    sInfoSelected: '',
                    sSearch: 'Search:',
                    sLoadingRecords: 'Searching...',
                    paginate: {
                        first: "<<",
                        previous: "<",
                        next: ">",
                        last: ">>"
                    },
                },
                dom: '<"dom">frtp',
                lengthChange: false,
                paging: true,            
                order: [[0, 'desc']],
                columnDefs: [{
                    targets: -1,
                    orderable: false,
                    responsivePriority: 1,
                    width: '10%',
                }],
                ajax: {
                    url: "../models/SessionDurPerM.Model.php",
                    data: function() {
                        return {
                             year: $('#dateSDurPerM').val().substring(0,4), //---------- INPUT
                             month: $('#dateSDurPerM').val().substring(5,7) //---------- INPUT
                        };
                    },
                type: "POST",
                dataSrc: ""
                },
                columns: [
                    { data: 'session_cant',
                        render: DataTable.render.number( '.', null, 0)
                    },
                    { data: 'session_duration_h' },
                    { data: 'session_duration_m' }
                ]

            });
        }
        
    }
    // ------------ END REPORT 3 ------------------------------


    // ------------ REPORT 4 ------------------------------
    
    function showReport4(){
        $('#div_dateUserLog3Cons2M').attr('hidden', false);
        $('#div_UserLog3Cons2M').attr('hidden', false);        
    }

    function hideReport4(){
        $('#div_dateUserLog3Cons2M').attr('hidden', true);
        $('#div_UserLog3Cons2M').attr('hidden', true);
        destroyDataTable('table_UserLog3Cons2M');        
    }

    $('#dateUserLog3Cons2M').datetimepicker({
        locale: 'es',
        format: 'YYYY/MM'
    });

    //BUTTON SEARCH
    $('#searchUserLog3Cons2M').on('click', function(){
        if( $('#dateUserLog3Cons2M').val() === ''){
            alert('Please select a date first');            
        }
        else
        {
            //CALC OF PREVIOUS MONTH
            let date = $('#dateUserLog3Cons2M').val();
            let year= date.substring(0,4);
            let month= date.substring(5,7);
            let monthPrev = (month == '01') ? '12' : (month - 1).toString();
            let yearPrev = (month == '01') ? year - 1 : year;
            monthPrev = (monthPrev.length === 1 ) ? '0' + monthPrev : monthPrev;
            let datePrev = yearPrev + '/' +monthPrev;

            //SHOWING DATA IN TABLE
            datatableUserLog3Cons2M();
            //TABLE TITLE
            $("#alertUserLog3Cons2M").html('<h4><span>SHOWING RESULTS OF MONTHS '+ datePrev +' AND '+ date +'</span></h4>');
            
        }
    });

    function datatableUserLog3Cons2M(){        
        //IF DATATABLE EXITS RELOAD ELSE MAKE 
        if ($.fn.dataTable.isDataTable( "#table_UserLog3Cons2M" )){
            let api = $( "#table_UserLog3Cons2M" ).dataTable().api();
            api.ajax.reload();
        }
        else{
            var table = $("#table_UserLog3Cons2M")
            .DataTable({
                responsive: true,
                language: {
                    sZeroRecords: 'No results found',
                    sEmptyTable: 'No results found',
                    sInfoFiltered: '',
                    sInfoPostFix: '',
                    sInfoSelected: '',
                    sSearch: 'Search:',
                    sLoadingRecords: 'Searching...',
                    paginate: {
                        first: "<<",
                        previous: "<",
                        next: ">",
                        last: ">>"
                    },
                },
                dom: '<"dom">frtp',
                lengthChange: false,
                paging: true,            
                order: [[0, 'desc']],
                columnDefs: [{
                    targets: -1,
                    orderable: false,
                    responsivePriority: 1,
                    width: '10%',
                }],
                ajax: {
                    url: "../models/UserLog3Cons2M.Model.php",
                    data: function() {
                        return {
                             year: $('#dateUserLog3Cons2M').val().substring(0,4), //---------- INPUT
                             month: $('#dateUserLog3Cons2M').val().substring(5,7) //---------- INPUT
                        };
                    },
                type: "POST",
                dataSrc: ""
                },
                columns: [
                    { data: 'id' },
                    { data: 'username' },
                    { data: 'user_names' }
                ]

            });
        }
        
    }
    // ------------ END REPORT 4 ------------------------------


});