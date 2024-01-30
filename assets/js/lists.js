let selectedListId = null;

function updateList() {
    fetch('http://localhost/finalv2/controllers/ListController.php', {
        method: 'GET',
    })
        .then(response => response.json())
        .then(data => {
            const listContainer = document.querySelector('#list-container');
            listContainer.innerHTML = '';
            if (data.length === 0) {
                addList('My Day');
                addList('Personal');
                addList('Work');
            } else {
                data.forEach((list, index) => {
                    const item = document.createElement('li');
                    item.id = "list-" + list.id;

                    const itemName = document.createElement('span');
                    itemName.textContent = list.name;
                    itemName.addEventListener('click', () => {
                        selectList(list.id);
                    });

                    const deleteBtn = document.createElement('button');
                    deleteBtn.innerHTML = '<i class="fas fa-trash-alt"></i>';
                    deleteBtn.style.display = 'none'; // Make the button invisible by default
                    deleteBtn.classList.add('btn', 'btn-link', 'delete-list-btn');
                    deleteBtn.addEventListener('click', () => {
                        deleteList(list.id);
                    });

                    item.appendChild(itemName);
                    item.appendChild(deleteBtn);

                    listContainer.appendChild(item);
                });
                selectFirstList();
            }
        });
}


function selectFirstList() {
    const firstListItem = document.querySelector('#list-container li');
    if (firstListItem) {
        selectList(firstListItem.id.split('-')[1]);
    }
}

function addList(name) {
    fetch('http://localhost/finalv2/controllers/ListController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'name': name,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateList();
                document.querySelector('#list-input').value = '';
            } else {
                console.log('Error adding list');
            }
        })
        .catch(error => {
            console.log('An error occurred:', error);
        });
}

function selectList(listId) {
    // Make all delete buttons invisible
    const allDeleteBtns = document.querySelectorAll('.delete-list-btn');
    allDeleteBtns.forEach(btn => {
        btn.style.display = 'none';
    });

    const listItems = document.querySelectorAll('#list-container li');

    listItems.forEach(item => {
        item.classList.remove('selected');
    });

    const selectedItem = document.querySelector('#list-' + listId);
    selectedItem.classList.add('selected');

    // Make the delete button of the selected list visible
    const deleteBtn = selectedItem.querySelector('.delete-list-btn');
    deleteBtn.style.display = 'inline-block'; 

    selectedListId = listId;
    window.global.selectedListId = listId;

    updateTaskList(); // Update task list when a list is selected

    const selectedListName = document.querySelector('#selected-list-name');
    const listName = document.querySelector('#list-' + listId).textContent;
    selectedListName.textContent = listName;

    const dateInfo = document.querySelector('#date-info');
    const date = new Date();
    const options = { weekday: 'long', month: 'long', day: 'numeric' };
    const dateString = date.toLocaleDateString('en-US', options);
    dateInfo.textContent = dateString;
}

function deleteList(listId) {
    fetch('http://localhost/finalv2/controllers/ListController.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'id': listId,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateList();
            } else {
                console.log('Error deleting list');
            }
        })
        .catch(error => {
            console.log('An error occurred:', error);
        });
}

document.querySelector('#add-list-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const listName = document.querySelector('#list-input').value;
    if (listName) {
        addList(listName);
    } else {
        alert('Please fill in all fields');
    }
});

updateList();
