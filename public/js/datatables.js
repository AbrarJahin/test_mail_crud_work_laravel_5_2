$(document).ready(function()
{
//Admin - User - Start//////////////////////////////////////////////////////////////////////////////////////////
    var datatable_id = "employee-grid";
    var dataTable = $('#'+datatable_id).DataTable(
    {
    	"processing": true,
    	"serverSide": true,
    	"ajax":
    	{
    		url :$('meta[name=terget_ajax_url]').attr("content"), // json datasource
    		type: "post",  // method  , by default get
    		error: function()
    		{  // error handling
    			$("."+datatable_id+"-error").html("");
    			$("#"+datatable_id).append('<tbody class="'+datatable_id+'-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
    			$("#"+datatable_id+"_processing").css("display","none");
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

    $('#'+datatable_id+' tbody').on( 'click', 'button.activate', function ()	//Handeling Edit Button Click
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

    $('#'+datatable_id+' tbody').on( 'click', 'button.suspend', function ()	//Handeling Edit Button Click
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

    $('#'+datatable_id+' tbody').on( 'click', 'button.delete', function ()	//Handeling Delete Button Click
    {
    	if (confirm('Are you sure you want to delete this thing from the database?'))
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
    	}
    	else
    	{
    	    alert("Not Deleted");
    	}
    });
//Admin - User - End//////////////////////////////////////////////////////////////////////////////////////////

//Admin - Article - Start//////////////////////////////////////////////////////////////////////////////////////////
	var datatable_id = "admin_articles";
	var admin_articles_table = $('#'+datatable_id).DataTable(
	{
		"processing": true,
		"serverSide": true,
		"ajax":
		{
			url :$('meta[name=terget_ajax_url]').attr("content"), // json datasource
			type: "post",  // method  , by default get
			error: function()
			{  // error handling
				$("."+datatable_id+"-error").html("");
				$("#"+datatable_id).append('<tbody class="'+datatable_id+'-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#"+datatable_id+"_processing").css("display","none");
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
						{	"data": "created_at"	},
						{	"data": null			}
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
								"defaultContent": '<div style="min-width:200px" class="btn-group" role="group"><button type="button" class="activate_article btn btn-success btn-sm">Activate</span></button><button type="button" class="suspend_article btn btn-warning btn-sm">Suspend</button><button type="button" class="delete_article btn btn-danger btn-sm">Delete</button></div>'
							}
						],
		dom: 'l<"toolbar">Bfrtip',	//"Bfrtip" is for column visiblity - B F and R become visible
		initComplete:	function()	//Adding Custom button in Tools
						{
							$("div.toolbar").html('<button onclick="add_new_user()" type="button" class="btn btn-info btn-sm" style="float:right;">Add New User</button>');
						}
	});

		//Activate Article Button Clicked
	$('#'+datatable_id+' tbody').on( 'click', 'button.activate_article', function ()	//Handeling Edit Button Click
	{
		var data = admin_articles_table.row( $(this).parents('tr') ).data();
		var clicked_id = data['id'];
		//alert("activate "+data['id']);	//id = index of ID sent from server
		$.ajax({
		    type: 'PUT',
		    url: $('meta[name=terget_ajax_url]').attr("content")+'/activate',
		    data: {
		        'id': clicked_id,
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

	//Suspand Article Button Clicked
	$('#'+datatable_id+' tbody').on( 'click', 'button.suspend_article', function ()	//Handeling Edit Button Click
	{
		var data = admin_articles_table.row( $(this).parents('tr') ).data();
		var clicked_id = data['id'];
		$.ajax({
			    type: 'PUT',
			    url: $('meta[name=terget_ajax_url]').attr("content")+'/suspend',
			    data: {
			        'id': clicked_id
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

	//Delete Article Button Clicked
	$('#'+datatable_id+' tbody').on( 'click', 'button.delete_article', function ()	//Handeling Delete Button Click
	{
		var data = admin_articles_table.row( $(this).parents('tr') ).data();
		var clicked_id = data['id'];
		if (confirm('Are you sure you want to delete this thing from the database?'))
		{
			$.ajax({
			    type: 'DELETE',
			    url: $('meta[name=terget_ajax_url]').attr("content")+'/delete',
			    data: {
			        'id': clicked_id
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
		}
		else
		{
		    alert("Not Deleted");
		}
	});
//Admin - Article - End//////////////////////////////////////////////////////////////////////////////////////

//For User public Articles list Datatables - Start////////////////////////////////////////////////////////////////////////////////
	var id_name = "all_articles";
	var all_articles_table = $('#'+id_name).DataTable(
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
//For User public Articles list Datatables - End////////////////////////////////////////////////////////////////////////////////

//For User written Articles list Datatables - Start////////////////////////////////////////////////////////////////////////////////
	id_name = "my_articles";
	var my_articles_table = $('#'+id_name).DataTable(
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
						{	"data": "created_at"	},
						{	"data": null			}
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
								"defaultContent": '<div style="min-width:70px" class="btn-group" role="group"><button type="button" class="edit btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button><button type="button" class="delete btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div>'
							}
						],
		dom: 'l<"toolbar">Bfrtip',	//"Bfrtip" is for column visiblity - B F and R become visible
		initComplete:	function()	//Adding Custom button in Tools
						{
							$("div.toolbar").html('<button onclick="add_new_article()" type="button" class="btn btn-info btn-sm" style="float:right;">Add New Article</button>');
						}
	});

	//Edit Article Button Clicked
	$('#'+id_name+' tbody').on( 'click', 'button.edit', function ()	//Handeling Edit Button Click
	{
		var data = my_articles_table.row( $(this).parents('tr') ).data();
		$('#edit_id').val(data['id']);
		$.ajax({
				type:	'POST',
				url:	$('meta[name=terget_ajax_url]').attr("content")+'/get',
				data:	{
							'id'		: data['id']
						},
				headers:
				{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(data)
				{
					$.each(data, function(index, element)
					{
						$('#edit_title').val(data['title']);
						$("#edit_content").val(data['content']);
					});
				}
			});
		$("#editData").modal({}).draggable();
		$('#editData').modal('show');
	});

	//Delete Article Button Clicked
	$('#'+id_name+' tbody').on( 'click', 'button.delete', function ()	//Handeling Delete Button Click
	{
		var data = my_articles_table.row( $(this).parents('tr') ).data();
		if (confirm('Are you sure you want to delete this thing from the database?'))
		{
		    $.ajax({
			    type: 'DELETE',
			    url: $('meta[name=terget_ajax_url]').attr("content")+'/delete',
			    data:
			    {
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
		}
		else
		{
		    alert("Not Deleted");
		}
	});
//For User written Articles list Datatables - End////////////////////////////////////////////////////////////////////////////////

});

function add_new_user()
{
	alert("Add new user, not required, so not implemented");
}

function add_new_article()			//Datatable add new user in admin-users
{
	$('#myModal').modal('show');
}
