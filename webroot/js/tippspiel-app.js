/* ========================================================
*
* MVP Ready - Lightweight & Responsive Admin Template
*
* ========================================================
*
* File: mvpready-admin.js
* Version: 1.0.0
* Author: Jumpstart Themes
* Website: http://mvpready.com
*
* ======================================================== */

var tippspiel_admin = function () {

	"use strict"

	var initLayoutToggles = function () {
		$('.navbar-toggle, .mainnav-toggle').click (function (e) {
			$(this).toggleClass ('is-open')
		})
	}

	var initNoticeBar = function () {
		$('.noticebar > li > a').click (function (e) {
			if (mvpready_core.isLayoutCollapsed ()) {
				window.location = $(this).prop ('href')
			}
		})
	}

  var setMatchname = function () {
    $( ".MatchTeamName" ).change(function() {
      alert($('#MatchTeam1Id option:selected').text());
      alert($('#MatchTeam2Id option:selected').text());
      $('#MatchName').val($('#MatchTeam1Id option:selected').text() + ' - ' + $('#MatchTeam2Id option:selected').text());
    });
  }

  var loadRoundTipps = function (round) {
    var request = $.ajax({
      url: "/entertipps/" + round,
      dataType: "html"
    });
    
    request.done(function( msg ) {
      $( "#entertipps" ).html( msg );
    });
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  }

  var loadTippsOverview = function (round) {
    var request = $.ajax({
      url: "/tipps/overview/" + round,
      dataType: "html"
    });
    
    request.done(function( msg ) {
      $( "#tippsoverview" ).html( msg );
    });
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  }

	return {
		init: function () {
			// Layouts
			mvpready_core.navEnhancedInit ()
			mvpready_core.navHoverInit ({ delay: { show: 250, hide: 350 } })      
			initLayoutToggles ()
			initNoticeBar ()

      setMatchname ()


			// Components
			mvpready_core.initAccordions ()		
			mvpready_core.initFormValidation ()
			mvpready_core.initTooltips ()
			mvpready_core.initBackToTop ()		
			mvpready_core.initLightbox ()
		},
    loadTippsOverview: loadTippsOverview,
    loadRoundTipps: loadRoundTipps
	}

}()

$(function () {
	tippspiel_admin.init ()
})