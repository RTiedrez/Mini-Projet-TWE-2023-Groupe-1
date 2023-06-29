// Mini projet TWE 2023 - Groupe 1
// Fichier réalisé par Jules Dumezy

var url = "libs/search_requests.php"

function loadContent() {
	$('#img-load').hide();
	$.ajax({
		url: url,
		method: 'POST',
		data: {name:"",action:"list"},
		success: function(result) {
			$('#search-results').html(result);
		}
	});
}

$(document).ready(function(){
	
	loadContent();
	
	// Affichage dynamique des utilisateurs
	$('#search-requesters').keyup(function() {
		$('#img-load').show();
		var name = $(this).val();
		
		$.ajax({
			url: url,
			method: 'POST',
			data: {name:name,action:"list"},
			success: function(result) {
				if (result != $('#search-results').html()) {
					$('#search-results').html(result);
				}
			}
		});
		$('#img-load').hide();
	});
	
	$("#search-results").on("click", ".accept", function() {
		var clickedUser = $(this).closest(".item").find('p').text();
		
		$.ajax({
			url: url,
			method: 'POST',
			data: {name:clickedUser,action:"accept"},
			success: function(result) {
				loadContent();
			}
		});
	});
	
	$("#search-results").on("click", ".decline", function() {
		var clickedUser = $(this).closest(".item").find('p').text();
		
		$.ajax({
			url: url,
			method: 'POST',
			data: {name:clickedUser,action:"decline"},
			success: function(result) {
				loadContent();
			}
		});
	});	
	
});

