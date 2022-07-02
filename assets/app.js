var BlurbMaker = {

    setFlippyEvents( flippy ){

        flippy.trigger.addEventListener( 'click', ()=> BlurbMaker.toggleFlippy( flippy ) );

    },

    setBlurbEvents( blurb ){

        blurb.trigger.addEventListener( 'click', function( e ){

            blurb.clickOutsideData = {

                path: e.composedPath(),
                bounds: null

            };

            BlurbMaker.toggleBlurb( blurb );

        });

    },

    toggleFlippy( flippy ){

        // trigger: options.flippy.flippies[i],
        // targets: options.flippy.flippies[i].parentNode.querySelectorAll( ':scope > *:not(.flippy)' ),
        // flippyClass: options.flippy.flippyClass,
        // flippyLength: options.flippy.flippies[i].parentNode.querySelectorAll( ':scope > *:not(.flippy)' ).length,

        let currentFlip = null;
        let maxFlips = flippy.targets.length - 1;
        let nextFlip = null;

        for( let i = 0; i < flippy.targets.length; i++ )
        {
            if( flippy.targets[i].classList.contains( flippy.flippyClass ) === true )
            {
                flippy.targets[i].classList.remove( flippy.flippyClass );

                currentFlip = i;
            }
        }

        if( currentFlip === null )
        {
            flippy.targets[ 0 ].classList.add( flippy.flippyClass );
        }
        else
        {
            nextFlip = currentFlip + 1 > maxFlips ? 0 : currentFlip + 1;

            flippy.targets[ nextFlip ].classList.add( flippy.flippyClass );
        }

    },

    toggleBlurb( blurb ){

        let classCondition = blurb.blurb.classList.contains( blurb.toggleClass );

        if( classCondition === true )
        {
            blurb.blurb.classList.remove( blurb.toggleClass );
        }
        else if( classCondition === false )
        {
            // Resetting some CSS before getBoundingClientRect
            blurb.target.style.height = null;
            blurb.target.style.width = null;

            this.positionBlurb( blurb );

            blurb.blurb.classList.add( blurb.toggleClass );
        }


    },

    positionBlurbResetBounds( blurb ){

        let dataOne = blurb.blurb.getBoundingClientRect();
        let dataTwo = blurb.target.getBoundingClientRect();

        blurb.clickOutsideData.bounds = {};

        blurb.clickOutsideData.bounds.container = {

            height: dataOne.height,
            width: dataOne.width,
            top: dataOne.top,
            right: dataOne.right,
            bottom: dataOne.bottom,
            left: dataOne.left,
            x: dataOne.x,
            y: dataOne.y,
            pageTop: dataOne.top + window.pageYOffset,
            pageRight: dataOne.right + window.pageXOffset,
            pageBottom: dataOne.bottom + window.pageYOffset,
            pageLeft: dataOne.left + window.pageXOffset

        };

        blurb.clickOutsideData.bounds.target = {

            height: dataTwo.height,
            width: dataTwo.width,
            top: dataTwo.top,
            right: dataTwo.right,
            bottom: dataTwo.bottom,
            left: dataTwo.left,
            x: dataTwo.x,
            y: dataTwo.y,
            pageTop: dataTwo.top + window.pageYOffset,
            pageRight: dataTwo.right + window.pageXOffset,
            pageBottom: dataTwo.bottom + window.pageYOffset,
            pageLeft: dataTwo.left + window.pageXOffset

        };

    },

    positionBlurb( blurb ){

        // First set the bounds to gather data,
        // then fit the blurb top or bottom,
        // then reset the bounds for fresh data,
        // then move it on the X axis

        this.positionBlurbResetBounds( blurb );

        let dataContainer = blurb.clickOutsideData.bounds.container;
        let dataTarget = blurb.clickOutsideData.bounds.target;
        let s = blurb.target.style;
        let isBlurbFixed = blurb.blurb.classList.contains( blurb.fixedElementClass );
        let pageHeight = window.innerHeight >= document.body.offsetHeight ? window.innerHeight : document.body.offsetHeight;
        let pageWidth = window.innerWidth >= document.body.offsetWidth ? window.innerWidth : document.body.offsetWidth;

        // Values for a CSS transform translate( x, x ) statement
        let topOrBottom = null;
        let leftOrRight = null;

        // x < 0 would not fit, x > 0 would fit
        let topCheck = dataContainer.top - dataTarget.height;
        let pageTopCheck = dataContainer.pageTop - dataTarget.height;
        let bottomCheck = (window.innerHeight - dataContainer.bottom) - dataTarget.height;
        let pageBottomCheck = (pageHeight - dataContainer.pageBottom) - dataTarget.height;
        let leftCheck = null;

        // Checks whether the blurb will fit in viewport top/bottom, (if not) then page top/bottom, (if not) then forces max height
        if( topCheck < 0 )
        {
            if( bottomCheck < 0 )
            {
                if( pageTopCheck < 0 || isBlurbFixed )
                {
                    if( pageBottomCheck < 0 || isBlurbFixed )
                    {
                        if( dataContainer.pageTop >= (pageHeight - dataContainer.pageBottom) || (isBlurbFixed && (dataContainer.top >= (window.innerHeight - dataContainer.bottom))) )
                        {
                            topOrBottom = "-100%";
                            s.top = "0%";
                            s.height = isBlurbFixed ? `${dataContainer.top - blurb.scrollbarSize}px` : `${dataContainer.pageTop - blurb.scrollbarSize}px`;
                        }
                        else
                        {
                            topOrBottom = "0%";
                            s.top = "100%";
                            s.height = isBlurbFixed ? `${dataContainer.bottom - blurb.scrollbarSize}px` : `${dataContainer.pageBottom - blurb.scrollbarSize}px`;
                        }
                    }
                    else if( pageBottomCheck >= 0 )
                    {
                        topOrBottom = "0%";
                        s.top = "100%";
                    }
                    else{ console.error("Problem with positionBlurb()!"); }
                }
                else if( pageTopCheck >= 0 )
                {
                    topOrBottom = "-100%";
                    s.top = "0%";
                }
                else{ console.error("Problem with positionBlurb()!"); }
            }
            else if( bottomCheck >= 0 )
            {
                topOrBottom = "0%";
                s.top = "100%";
            }
            else{ console.error("Problem with positionBlurb()!"); }
        }
        else if( topCheck >= 0 )
        {
            topOrBottom = "-100%";
            s.top = "0%";
        }
        else{ console.error("Problem with positionBlurb()!"); }

        // Reset bounds in case the width was changed
        this.positionBlurbResetBounds( blurb );

        leftCheck = dataContainer.left - ((dataTarget.width - dataContainer.width) / 2);

        if( leftCheck < 0 )
        {
            leftOrRight = `-${dataContainer.left}px`;
            s.left = "0%";

            if( pageWidth - dataContainer.right < dataTarget.width - dataContainer.width ) s.width = `${pageWidth - blurb.scrollbarSize}px`;
        }
        else if( leftCheck >= 0 )
        {
            leftOrRight = "-50%"
            s.left = "50%"
        }
        else{ console.error("Problem with positionBlurb()!"); }

        s.transform = `translate(${leftOrRight}, ${topOrBottom})`;
    },

    init( options ){

        // flippy
        for( let i = 0; i < options.flippy.flippies.length; i++ )
        {
            let newObject = {

                trigger: options.flippy.flippies[i],
                targets: options.flippy.flippies[i].parentNode.querySelectorAll( ':scope > *:not(.flippy)' ),
                flippyClass: options.flippy.flippyClass,

            };

            newObject.targets[0].classList.add( newObject.flippyClass );

            this.setFlippyEvents( newObject );
        }

        // Blurbs
        for( let i = 0; i < options.blurbs.blurbs.length; i++ )
        {
            let newObject = {

                blurb: options.blurbs.blurbs[i],
                trigger: options.blurbs.blurbs[i].querySelector( ':scope .'+options.blurbs.triggerClass ),
                target: options.blurbs.blurbs[i].querySelector( ':scope .'+options.blurbs.targetClass ),
                toggleClass: options.blurbs.toggleClass,
                fixedElementClass: options.blurbs.fixedElementClass,
                scrollbarSize: options.blurbs.scrollbarSize

            };

            this.setBlurbEvents( newObject );
        }

    }

};

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

        for( let i = 0; i < options.widgets.length; i++ )
        {
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

var LoadingBar = {

    setStaticBar( data ) {

        const outers = data.outerElements;
        const inners = data.innerElements;

        for( let i = 0; i < outers.length; i++ )
        {
            const attribute = outers[i].getAttribute( data.static.attribute );

            inners[i].style.width = `${attribute}%`
        }

    },

    init( options ) {

        for( let i = 0; i < options.length; i++ )
        {
            let data = options[i];

            if( typeof options[i].static === "object" )
            {
                this.setStaticBar( data );
            }
        }

    }

};

BlurbMaker.init({

    // To do: add ACTIVATED logic
    blurbs: {

        blurbs: document.querySelectorAll( '.blurb' ),
        triggerClass: 'button',
        targetClass: 'blurb-target',
        toggleClass: 'toggled',
        activatedClass: 'activated',
        fixedElementClass: 'fixed-blurb',
        // scrollbar width and height as one Number value representing px
        scrollbarSize: 6

    },

    flippy: {

        flippies: document.querySelectorAll( '.flippy' ),
        flippyClass: 'flipped'

    }

});

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
            activeClass: "widget-contact-active"
        }
    ]

});

LoadingBar.init([
    // the structure has to be: the outer loading bar (container) and the inner (completion %)
    // group: a group of loading bars that have the same base settings, select the outer loading bar
    // static: if the loading bar is static, this is an object
    //      attribute: the attribute in which the loading bar's % is stored, in integers
    //      static will set the loading bar's width to the % of the value in the attribute

    {
        outerElements: document.querySelectorAll( "[skill-data]" ),
        innerElements: document.querySelectorAll( "[skill-data] > div" ),
        static: {
            attribute: "skill-data"
        }
    }
]);

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
