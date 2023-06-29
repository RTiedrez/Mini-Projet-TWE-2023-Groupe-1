// Mini projet TWE 2023 - Groupe 1
// Fichier réalisé par Jules Dumezy

var url = "libs/search_dashboard.php"

// Chargement du contenu initial
function loadContent() {
	$('#img-load').hide();
	$.ajax({
		url: url,
		method: 'POST',
		data: {name:""},
		success: function(result) {
			$('#search-results').html(result);
		}
	});
}

$(document).ready(function(){
	
	// Affichage de tous les utilisateurs
	loadContent();
	
	// Affichage dynamique des utilisateurs
	$('#search-user').keyup(function() {
		$('#img-load').show();
		var name = $(this).val();
		
		$.ajax({
			url: url,
			method: 'POST',
			data: {name:name},
			success: function(result) {
				if (result != $('#search-results').html()) {
					$('#search-results').html(result);
				}
			}
		});
		$('#img-load').hide();
	});
	
	// Affichage du dashboard de l'utilisateur
	// TODO
	$("#search-results").on("click", ".user", function() {
		var clickedUser = $(this).text();
		// Faire quelque chose
	});
});

