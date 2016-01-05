$(document).ready(function()
{
//For Admin User list Datatables - Start////////////////////////////////////////////////////////////////////////////////
	var id_name = "employee-grid";
	var dataTable = $('#'+id_name).DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url :$('meta[name=terget_ajax_url]').attr("content"), // json datasource
			type: "post",  // method  , by default get
			error: function()
			{  // error handling
				$("."+id_name+"-error").html("");
				$("#"+id_name+"").append('<tbody class="'+id_name+'-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#"+id_name+"_processing").css("display","none");
			},
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		},
		"columns":	[				//Name should be same as PHP file JSON NAmes and ordering should be as in the HTML file
						{	"data": "name"			},
						{	"data": "email"		},
						{	"data": "user_type"			},
						{	"data": "is_active"					},		//If it is not null then shorting buttons would not be shown
						{	"data": "created_at"					},
						{	"data": null					}
					],
		//"pagingType": "full_numbers",	//Adding Last and First in Pagination
		stateSave: true,
		"columnDefs":	[								//For Action Buttons (Edit and Delete button) adding in the Action Column
							{
								//"visible": false,
								"orderable": false,		//Turn off ordering
								"searchable": false,	//Turn off searching
								"targets": [5],			//Going to last column - 6 is the last column index because o is starting index
								"data": null,			//Not receiving any data
								"defaultContent": '<div style="min-width:200px" class="btn-group" role="group"><button type="button" class="activate btn btn-success btn-sm">Activate</span></button><button type="button" class="suspend btn btn-warning btn-sm">Suspend</button><button type="button" class="delete btn btn-danger btn-sm">Delete</button></div>'
							}
						],
		dom: 'l<"toolbar">Bfrtip',	//"Bfrtip" is for column visiblity - B F and R become visible
		initComplete:	function()	//Adding Custom button in Tools
						{
							$("div.toolbar").html('<button onclick="add_new_user()" type="button" class="btn btn-info btn-sm" style="float:right;">Add New User</button>');
						}
	});

	$('#'+id_name+' tbody').on( 'click', 'button.activate', function ()	//Handeling Edit Button Click
	{
		var data = dataTable.row( $(this).parents('tr') ).data();
		//alert("activate "+data['id']);	//id = index of ID sent from server
		$.ajax({
		    type: 'PUT',
		    url: $('meta[name=terget_ajax_url]').attr("content")+'/activate',
		    data: {
		        'id': data['id'],
		        'parameter2': 'example data - for future use'
		    },
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		    success: function(msg)
		    {
		        alert(msg);
		        location.reload();
		    }
		});
	});

	$('#'+id_name+' tbody').on( 'click', 'button.suspend', function ()	//Handeling Edit Button Click
	{
		var data = dataTable.row( $(this).parents('tr') ).data();
		$.ajax({
		    type: 'PUT',
		    url: $('meta[name=terget_ajax_url]').attr("content")+'/suspend',
		    data: {
		        'id': data['id']
		    },
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		    success: function(msg)
		    {
		        alert(msg);
		        location.reload();
		    }
		});
	});

	$('#'+id_name+' tbody').on( 'click', 'button.delete', function ()	//Handeling Delete Button Click
	{
		var data = dataTable.row( $(this).parents('tr') ).data();
		$.ajax({
		    type: 'DELETE',
		    url: $('meta[name=terget_ajax_url]').attr("content")+'/delete',
		    data: {
		        'id': data['id']
		    },
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
		    success: function(msg)
		    {
		        alert(msg);
		        location.reload();
		    }
		});
	});
//For Admin User list Datatables - End////////////////////////////////////////////////////////////////////////////////


//For User Articles list Datatables - Start////////////////////////////////////////////////////////////////////////////////
	id_name = "all_articles";
	var dataTable = $('#'+id_name).DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url :$('meta[name=terget_ajax_url]').attr("content"), // json datasource
			type: "post",  // method  , by default get
			error: function()
			{  // error handling
				$("."+id_name+"-error").html("");
				$("#"+id_name+"").append('<tbody class="'+id_name+'-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#"+id_name+"_processing").css("display","none");
			},
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		},
		"columns":	[				//Name should be same as PHP file JSON NAmes and ordering should be as in the HTML file
						{	"data": "name"			},
						{	"data": "title"			},
						{	"data": "content"		},
						{	"data": "status"		},		//If it is not null then shorting buttons would not be shown
						{	"data": "created_at"	}
					],
		//"pagingType": "full_numbers",	//Adding Last and First in Pagination
		stateSave: true,
		dom: 'l<"toolbar">Bfrtip',	//"Bfrtip" is for column visiblity - B F and R become visible
		initComplete:	function()	//Adding Custom button in Tools
						{
							$("div.toolbar").html('<button onclick="add_new_article()" type="button" class="btn btn-info btn-sm" style="float:right;">Add New Article</button>');
						}
	});
//For Admin User list Datatables - End////////////////////////////////////////////////////////////////////////////////

//For User Articles list Datatables - Start////////////////////////////////////////////////////////////////////////////////
	id_name = "my_articles";
	var dataTable = $('#'+id_name).DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url :$('meta[name=terget_ajax_url]').attr("content"), // json datasource
			type: "post",  // method  , by default get
			error: function()
			{  // error handling
				$("."+id_name+"-error").html("");
				$("#"+id_name+"").append('<tbody class="'+id_name+'-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#"+id_name+"_processing").css("display","none");
			},
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		},
		"columns":	[				//Name should be same as PHP file JSON NAmes and ordering should be as in the HTML file
						{	"data": "name"			},
						{	"data": "title"			},
						{	"data": "content"		},
						{	"data": "status"		},		//If it is not null then shorting buttons would not be shown
						{	"data": "created_at"	}
					],
		//"pagingType": "full_numbers",	//Adding Last and First in Pagination
		stateSave: true,
		dom: 'l<"toolbar">Bfrtip',	//"Bfrtip" is for column visiblity - B F and R become visible
		initComplete:	function()	//Adding Custom button in Tools
						{
							$("div.toolbar").html('<button onclick="add_new_article()" type="button" class="btn btn-info btn-sm" style="float:right;">Add New Article</button>');
						}
	});
//For Admin User list Datatables - End////////////////////////////////////////////////////////////////////////////////


});

function add_new_user()			//Datatable add new user in admin-users
{
	alert("Add new user, not required, so not implemented");
}

function add_new_article()			//Datatable add new user in admin-users
{
	$('#myModal').modal('show');
}
