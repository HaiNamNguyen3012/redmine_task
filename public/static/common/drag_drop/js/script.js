let cards = document.querySelectorAll('.card-task');
let lists = document.querySelectorAll('.list-task');


cards.forEach((card) => {
    registerEventsOnCard(card);
});

lists.forEach((list) => {
    list.addEventListener('dragover', (e) => {
        e.preventDefault();
        let draggingCard = document.querySelector('.dragging');
        let cardAfterDraggingCard = getCardAfterDraggingCard(list, e.clientY);
        if (cardAfterDraggingCard) {

            cardAfterDraggingCard.parentNode.insertBefore(draggingCard, cardAfterDraggingCard);
        } else {
            list.appendChild(draggingCard);
        }

    });
});

function getCardAfterDraggingCard(list, yDraggingCard) {

    let listCards = [...list.querySelectorAll('.card-task:not(.dragging)')];

    return listCards.reduce((closestCard, nextCard) => {
        let nextCardRect = nextCard.getBoundingClientRect();
        let offset = yDraggingCard - nextCardRect.top - nextCardRect.height / 2;

        if (offset < 0 && offset > closestCard.offset) {
            return {offset, element: nextCard}
        } else {
            return closestCard;
        }

    }, {offset: Number.NEGATIVE_INFINITY}).element;

}

function registerEventsOnCard(card) {
    card.addEventListener('dragstart', (e) => {
        card.classList.add('dragging');
    });

    card.addEventListener('dragend', (e) => {
        let task_info = card.querySelector(".task-info");
        let task_info_id = task_info.getAttribute("data-id");
        task_info.setAttribute("data-drop", 1)
        updateTask(task_info_id);

        card.classList.remove('dragging');
    });
}
