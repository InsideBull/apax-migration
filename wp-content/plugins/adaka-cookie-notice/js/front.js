( function ( $ ) {

	$( document ).ready( function () {
		var cnDomNode = $( '#cookie-notice' );

		// handle set-cookie button click
		$( document ).on( 'click', '.cn-set-cookie', function ( e ) {
			e.preventDefault();
			var val = $( this ).data( 'cookie-set' )
			$( this ).setCookieNotice( val );
			
			if(val == "accept") {
				$(".cookie_notice_options *[data-cookie-set=\"accept\"]").addClass("active");
				$(".cookie_notice_options *[data-cookie-set=\"refuse\"]").removeClass("active");
			}
			else {
				$(".cookie_notice_options *[data-cookie-set=\"accept\"]").removeClass("active");
				$(".cookie_notice_options *[data-cookie-set=\"refuse\"]").addClass("active");
			}
		} );

		// display cookie notice
		if ( document.cookie.indexOf( cnArgs.cookieName ) === -1 || document.cookie.indexOf( cnArgs.cookieName+"="+cnArgs.cookieLoadValue ) !== -1 ) {
			if ( cnArgs.hideEffect === 'fade' ) {
				cnDomNode.fadeIn( 300 );
			} else if ( cnArgs.hideEffect === 'slide' ) {
				cnDomNode.slideDown( 300 );
			} else {
				cnDomNode.show();
			}
			$( 'body' ).addClass( 'cookies-not-accepted' );
		} else {
			cnDomNode.removeCookieNotice();
		}
	} );

	// set Cookie Notice
	$.fn.setCookieNotice = function ( cookie_value, send_url ) {
		var cnTime		= new Date(),
			cnLater		= new Date(),
			cnDomNode	= $( '#cookie-notice' );
		
		self = this;

		// set expiry time in seconds
		cnLater.setTime( parseInt( cnTime.getTime() ) + parseInt( cnArgs.cookieTime ) * 1000 );

		// set cookie
		cookie_value = cookie_value === 'accept' ? true : false;
		if(cookie_value) {
			document.cookie = cnArgs.cookieName + '='+cnArgs.cookieValue+';'+
							  'expires=' + cnLater.toGMTString() +';'+
							  ( cnArgs.cookieDomain !== undefined && cnArgs.cookieDomain !== '' ? 'domain=' + cnArgs.cookieDomain + '; ' : '' )+
							  ( cnArgs.cookiePath !== undefined && cnArgs.cookiePath !== '' ?'path=' +cnArgs.cookiePath +'; ' :'path=/; ' );
		}
		else {
			var cookies = document.cookie.split(";");
			for(var i=0; i < cookies.length; i++) {
				var equals = cookies[i].indexOf("=");
				var name = equals > -1 ? cookies[i].substr(0, equals) : cookies[i];
				var tmp_cookie = name +"="+cnArgs.cookieNoValue+";"+
								  "expires=Thu, 01 Jan 1970 00:00:00 GMT;"+
								  ( cnArgs.cookieDomain !== undefined && cnArgs.cookieDomain !== '' ?'domain=' +cnArgs.cookieDomain +'; ' :'' )+
								  ( cnArgs.cookiePath !== undefined && cnArgs.cookiePath !== '' ?'path=' +cnArgs.cookiePath +'; ' :'path=/; ' );
				document.cookie = tmp_cookie;
			}
			
			document.cookie = cnArgs.cookieName + '='+cnArgs.cookieNoValue+';'+
							  'expires=' + cnLater.toGMTString() +';'+
							  ( cnArgs.cookieDomain !== undefined && cnArgs.cookieDomain !== '' ?'domain=' +cnArgs.cookieDomain +'; ' :'' )+
							  ( cnArgs.cookiePath !== undefined && cnArgs.cookiePath !== '' ?'path=' +cnArgs.cookiePath +'; ' :'path=/; ' );
		}
		
		// trigger custom event
		if(typeof send_url == "undefined") {
			$.event.trigger( {
				type		: "setCookieNotice",
				value		: cookie_value,
				time		: cnTime,
				expires		: cnLater,
			} );
		}
		else {
			$.event.trigger( {
				type		: "setCookieNotice",
				value		: cookie_value,
				time		: cnTime,
				expires		: cnLater,
				href 		: send_url, 
			} );
		}

		// hide message container
		if ( cnArgs.hideEffect === 'fade' ) {
			cnDomNode.fadeOut( 300, function () {
				self.removeCookieNotice();
			} );
		} else if ( cnArgs.hideEffect === 'slide' ) {
			cnDomNode.slideUp( 300, function () {
				self.removeCookieNotice();
			} );
		} else {
			self.removeCookieNotice();
		}
	};

	// remove Cookie Notice
	$.fn.removeCookieNotice = function ( cookie_value ) {
		var cnDomNode	= $( '#cookie-notice' );
		
		$( 'body' ).removeClass( 'cookies-not-accepted' );
	}

} )( jQuery );
