// Import the necessary function for preloading images
import { getGrid } from './utils.js';
const HUB = () =>{


// Define a variable that will store the Lenis smooth scrolling object

// Element with class .columns
const grid = document.querySelector('.columns');
// All the columns class .column
const columns = [...grid.querySelectorAll('.column')];
// Map each column to its array of items and keep a reference of the image, its wrapper and the column
const items = columns.map((column, pos) => {
    return [...column.querySelectorAll('.column__item')].map(item => ({
        element: item,
        column: pos,
        wrapper: item.querySelector('.column__item-imgwrap'),
        image: item.querySelector('.column__item-img')
    }));
});

// All itemms
const mergedItems = items.flat();


const scroll = () => {
    const gridObj = getGrid(mergedItems.map(item => item.element));
    const rowMapping = {
        even: {
            skewX: 2,
            xPercent: -50,
            transformOrigin: '0% 50%'
        },
        odd: {
            skewX: -2,
            xPercent: 50,
            transformOrigin: '100% 50%'
        }
    };

    ['even', 'odd'].forEach(type => {
        gridObj.rows(type).flat().forEach(row => {
            gsap
                .timeline({
                    defaults: { ease: 'none' },
                    scrollTrigger: {
                        trigger: row,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true
                    }
                })
                .to(row.querySelector('.column__item-imgwrap'), {
                    xPercent: rowMapping[type].xPercent,
                    skewX: rowMapping[type].skewX
                }, 0)
                .to(row.querySelector('.column__item-img'), {
                    ease: 'power1.in',
                    startAt: {transformOrigin: rowMapping[type].transformOrigin},
                    scaleX: 1.4
                }, 0)

        });
    });
}
    scroll();
}

export default HUB;

