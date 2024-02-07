const setActionsAndCharsByCheckpoint = (el) => {
    const allActions = document.querySelectorAll('input[name="action"]');
    const allChars = document.querySelectorAll('input[name="char"]');
    const allLocks = document.querySelectorAll('.action-locked');

    const actionsParent = document.querySelector('.choose-scene .actions');
    const charsParent = document.querySelector('.choose-char .actions');

    allActions[0].checked = true;
    allChars[0].checked = true;
    document.querySelector('.choose-scene').textContent = 'Action';
    document.querySelector('.choose-char').textContent = 'Characters';

    allLocks.forEach(lock => {
        lock.classList.add('hidden');
    });

    const sortItems = (items) => {
        return Array.from(items).sort((a, b) => {
            // Sort by disabled status in reverse order
            return b.disabled - a.disabled;
        });
    };

    if (el.dataset.actions) {
        const actionsString = el.dataset.actions;
        const actionsArray = actionsString.split(' ');

        allActions.forEach(action => {
            if (!actionsArray.includes(action.id)) {
                action.disabled = true;
                const parentElement = action.parentElement;
                if (parentElement) {
                    const actionLockedElement = parentElement.querySelector('.action-locked');
                    if (actionLockedElement) {
                        actionLockedElement.classList.remove('hidden');
                    }
                }
            } else {
                action.disabled = false;
            }
        });
        const nonPremiumActions = Array.from(allActions).filter(action => action.disabled !== true);
        const availableActions = [];
        nonPremiumActions.forEach(action => {
            const elParent = action.parentElement.parentElement.parentElement;
            availableActions.push(elParent);
            // elParent.remove();
        })

        const firstActionElement = actionsParent.querySelector('.default-action');

        availableActions.forEach(action => {
            insertAfter(firstActionElement,action)
        });
    }

    if (el.dataset.chars) {
        const charsString = el.dataset.chars;
        const charsArray = charsString.split(' ');

        allChars.forEach(char => {
            if (!charsArray.includes(char.id)) {
                char.disabled = true;
                const parentElement = char.parentElement;
                if (parentElement) {
                    const charLockedElement = parentElement.querySelector('.action-locked');
                    if (charLockedElement) {
                        charLockedElement.classList.remove('hidden');
                    }
                }
            } else {
                char.disabled = false;
            }
        });

        const nonPremiumChars = Array.from(allChars).filter(action => action.disabled !== true);
        const availableChars = [];
        nonPremiumChars.forEach(action => {
            const elParent = action.parentElement.parentElement.parentElement;
            availableChars.push(elParent);
            // elParent.remove();
        })

        const firstActionElement = charsParent.querySelector('.default-char');

        availableChars.forEach(action => {
            insertAfter(firstActionElement,action)
        });
    }

    function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }

};

export default setActionsAndCharsByCheckpoint;