const charsFilter = (button, block) => {

    const categoryBtn  = document.querySelectorAll(button);
    const categoryBlocks  = document.querySelectorAll(block);

    const showCategoryBlock = (i) => {
        if (categoryBtn[i].dataset.id === 'all') {
            categoryBlocks.forEach(item => {
                item.classList.remove('hidden');

            });
        } else {
            categoryBlocks.forEach(item => {
                if (item.classList.contains(categoryBtn[i].dataset.id)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        }
        categoryBtn.forEach(item => item.classList.remove('active'));
        categoryBtn[i].classList.add('active');


    }

    categoryBtn.forEach((item, index) => {
        item.addEventListener('click', () => {
            showCategoryBlock(index);
        })
    });

    showCategoryBlock(0);


}

export default charsFilter;
