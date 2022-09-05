var BasicHandlers = {
    contactWidgetHover( data ) {
        if( data.container.classList.contains( data.activeClass ) === false ) data.container.classList.add( data.activeClass );

        data.timeouts.forEach( (id)=> window.clearTimeout(id) );
        data.timeouts.length = 0;
    },

    contactWidgetHoverEnd( data ) {
        const timeoutId = window.setTimeout( ()=> data.container.classList.remove( data.activeClass ), data.waitTime );

        data.timeouts.push( timeoutId );
    },

    contactWidgetClick( data ) {
        data.container.classList.toggle( data.activeClass );
    },

    init( options ) {
        for( let i = 0; i < options.widgets.length; i++ ) {
            const target = options.widgets[i].widget;
            const clickTarget = options.widgets[i].clickTarget;
            const data = options.widgets[i];

            data.timeouts = [];

            clickTarget.addEventListener( "click", (e)=> {
                if( window.innerWidth >= data.breakpoint ) return;
                this.contactWidgetClick( data, e );
            } );

            target.addEventListener( "mouseover", (e)=> {
                if( window.innerWidth < data.breakpoint ) return;
                this.contactWidgetHover( data, e )
            } );

            target.addEventListener( "mouseleave", (e)=> {
                if( window.innerWidth < data.breakpoint ) return;
                this.contactWidgetHoverEnd( data, e )
            } );
        }
    }
};

BasicHandlers.init({
    // container: the container of the widget, on which the activeClass will be placed
    // widget: the element of the contact widget
    // breakpoint: the css breakpoint at which point it switches between hover or click handlers
    // waitTime: the time to wait before closing the contact widget on hover
    // activeClass: the class that should be added when the contact widget is active
    widgets: [
        {
            container: document.querySelector( "#inner-header" ),
            widget: document.querySelector( "header .widget-contact" ),
            clickTarget: document.querySelector( "header .widget-contact > div:first-child > div:first-child" ),
            breakpoint: 900,
            waitTime: 750,
            activeClass: "widget-contact-active",
        },
    ],
});

class TimedClickToggleClass {
	constructor(toggleClass, time, targetContainer, targetClick) {
		this.toggleClass = toggleClass;
		this.time = time;
		this.targetContainer = targetContainer;
		this.targetClick = targetClick;
		
		const _data = {
			activeTimeouts: [],
			object: this,
		};
		
		this.targetClick.addEventListener(`click`, function(e) {
			const data = _data;
			const element = data.object.targetContainer;
			
			element.classList.toggle(data.object.toggleClass);
		});
		this.targetContainer.addEventListener(`mouseover`, function(e) {
			const data = _data;
			
			for(const id of data.activeTimeouts) {
				window.clearTimeout(id);
			}
		});
		this.targetContainer.addEventListener(`mouseleave`, function(e) {
			const data = _data;
			const element = this;
			
			data.activeTimeouts.push(window.setTimeout(function() {
				element.classList.remove(data.object.toggleClass);
			}, data.object.time));
		});
	}
}

for(const target of document.querySelectorAll(`#header-language-select`)) {
	new TimedClickToggleClass(
		`active`,
		450,
		target,
		target.querySelector(`:scope>p`),
	);
	
}

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/widgets.css';
import './scripts/widgets.js';