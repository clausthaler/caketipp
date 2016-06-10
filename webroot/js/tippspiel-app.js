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
      $('#MatchName').val($('#MatchTeam1Id option:selected').text() + ' - ' + $('#MatchTeam2Id option:selected').text());
    });
  }

  var refreshTippsStatistics = function () {
    var tipper = $('#TipperSelect option:selected').val();

    var request = $.ajax({
      url: '/tipps/statistics/' + tipper,
      dataType: "html"
    });
    
    request.done(function( msg ) {
      $( "#tippstatistics" ).html( msg );
    });

    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  }

  var refreshGroupTables = function () {
    var tipper = $('#TipperSelect option:selected').val();

    var request = $.ajax({
      url: '/matches/grouptables/' + tipper,
      dataType: "html"
    });
    
    request.done(function( msg ) {
      $( "#tippersgrouptables" ).html( msg );
    });

    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  }

  var loadTippsOverview = function (url) {
    var request = $.ajax({
      url: url,
      dataType: "html"
    });
    
    request.done(function( msg ) {
      $( "#tippsoverview" ).html( msg );
    });
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  }

  var togglelike = function (id) {
    var request = $.ajax({
      url: '/feeds/like/' + id,
      dataType: "html"
    });
    
    request.done(function( msg ) {
      $( "#commentlike-" + id ).html( msg );
    });
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  }

  var toggleMessagelike = function (id) {
    var request = $.ajax({
      url: '/messages/like/' + id,
      dataType: "html"
    });
    
    request.done(function( msg ) {
      $( "#messagelike-" + id ).html( msg );
    });
    request.fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
    });
  }

  var refreshTippsOverview = function (type) {
    var params;
    if ($('#RoundSelect option:selected').val() == 'timeline') {
      window.location = "/tipps/timeline";
    } else{
      if ($('#RoundSelect option:selected').val() == 'overview') {
        loadTippsOverview('/ranking');
      } else {
        if ($('#RoundSelect option:selected').val() == 'bonus') {
          loadTippsOverview('/tipps/bonusquestions');
        } else {
          if (type == 'round') {
            params = defineroundgroup();
          } else {
            params = defineroundgroup();
            if ($('#MatchFrom option:selected').val() != '') {
              params = params + '/from_match:' + $('#MatchFrom option:selected').val();
            };
            if ($('#MatchTo option:selected').val() != '') {
              params = params + '/to_match:' + $('#MatchTo option:selected').val();
            };
          };
        loadTippsOverview('/tipps/overview/' + params);
        }
      }      
    }
  }

  var defineroundgroup = function(){
    var roundgroup = $('#RoundSelect option:selected').val();
    var roundgrparr = roundgroup.split('-');
    var params = 'round:' + roundgrparr[0];
    if (roundgrparr[1]) {
      params = params + '/group:' + roundgrparr[1];
    };
    return params;
  }

  var messagerefresh = function() {
    $('#PublishMessage').attr('disabled', 'disabled');
  }

  var commentmodal = function(feedid) {
    $('#ModalFeedId').val(feedid);
    $('#myModal').modal('show');
    console.log($('#ModalFeedId').val());
  }

  var loadStreamPage = function(page) {
    $( "#feedStream" ).load( "/feeds/stream/page:" + page );
  }

  var showcommentbox = function(params) {
    var $newbox = $( ".shoutboxtemplate" ).clone();
    $( ".shoutboxchild" ).remove();
    $newbox.addClass('shoutboxchild').removeClass('shoutboxtemplate');
    $newbox.appendTo( "#" + params.target);
    $('.shoutboxchild input.ModalFeedId').val(params.feed);
    $('.shoutboxchild form').submit(function(e) {
      var postData = $(this).serializeArray();
      var formURL = $(this).attr("action");
      if ( $('.shoutboxchild textarea').val() != '' ) {    
        $.ajax({
          url : formURL,
          type: "POST",
          data : postData,
          success:function(data, textStatus, jqXHR) {
            $( "#feed-" + params.feed).html( data );
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert( "Request failed: " + textStatus );
          }
        });
      }
      e.preventDefault(); //STOP default action
      //    e.unbind(); //unbind. to stop multiple form submit.
    });

//    $( ".shoutboxtemplate" ).clone().appendTo( "#feedaction-" + feedid);
//    console.log($( "#feedaction-" + feedid ).html());
  }



  return {
    init: function () {

      // Layouts
      mvpready_core.initNavHover ({ delay: { show: 250, hide: 350 } })

      mvpready_core.initNavbarNotifications ()
      mvpready_core.initSidebarNav ()
      mvpready_core.initLayoutToggles ()
      mvpready_core.initBackToTop ()

      // Components
      mvpready_helpers.initAccordions ()
      mvpready_helpers.initFormValidation ()
      mvpready_helpers.initTooltips ()
      mvpready_helpers.initLightbox ()
      mvpready_helpers.initSelect ()
      mvpready_helpers.initIcheck ()
      mvpready_helpers.initDataTableHelper ()
      mvpready_helpers.initiTimePicker ()
      mvpready_helpers.initDatePicker ()
      mvpready_helpers.initColorPicker ()

      setMatchname ()
    },
    loadTippsOverview: loadTippsOverview,
    refreshTippsOverview: refreshTippsOverview,
    messagerefresh: messagerefresh,
    togglelike: togglelike,
    commentmodal: commentmodal,
    showcommentbox: showcommentbox,
    loadStreamPage: loadStreamPage,
    toggleMessagelike: toggleMessagelike,
    refreshGroupTables: refreshGroupTables,
    refreshTippsStatistics: refreshTippsStatistics
  }

}()

$(function () {
  tippspiel_admin.init ();
  $('#summernote-basic-demo').summernote ({ 
    height: 150 
  })
  
})