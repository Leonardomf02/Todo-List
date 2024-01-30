document.querySelector('#priority-filter').addEventListener('change', updateTaskList);
document.querySelector('#status-filter').addEventListener('change', updateTaskList);

function updateTaskList() {
    const listId = window.global.selectedListId;
    const priorityFilter = document.querySelector('#priority-filter').value;
    const statusFilter = document.querySelector('#status-filter').value;

    let url = `http://localhost/finalv2/controllers/TodoController.php?list_id=${listId}`;

    if (priorityFilter) {
        url += `&priority=${priorityFilter}`;
    }

    if (statusFilter) {
        url += `&status=${statusFilter}`;
    }

    fetch(url, {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
            const taskTable = document.querySelector('tbody');
            taskTable.innerHTML = '';
            data.forEach((task, index) => {
                const row = document.createElement('tr');

                let priorityClass = 'priority-cell ';
                switch (task.priority) {
                    case 'High':
                        priorityClass += 'bg-danger';
                        break;
                    case 'Medium':
                        priorityClass += 'bg-warning';
                        break;
                    case 'Low':
                        priorityClass += 'bg-success';
                        break;
                }

                row.innerHTML = `
                    <th scope="row" class="pe-5">${index + 1}</th>
                    <td class="text-start">${task.tasks}</td>
                    <td class="text-center">${task.status}</td>
                    <td class="text-center">${task.due_date}</td>
                    <td class="text-center ${priorityClass}">${task.priority}</td>
                    <td class="text-center">
                        <button class="btn btn-primary edit-btn" data-id="${task.id}" type="button">Edit</button>
                        <button class="btn btn-danger delete-btn" data-id="${task.id}" type="button">Delete</button>
                    </td>
        `;

                taskTable.appendChild(row);

                const editButton = row.querySelector('.edit-btn');
                const deleteButton = row.querySelector('.delete-btn');

                editButton.addEventListener('click', () => {
                    const taskId = editButton.dataset.id;
                    editTask(taskId);
                });

                deleteButton.addEventListener('click', () => {
                    const taskId = deleteButton.dataset.id;
                    deleteTask(taskId);
                });
            });
        })
        .catch(error => {
            console.log('An error occurred:', error);
        });
}

function resetTaskForm() {
    document.querySelector('#add-todo').value = '';
    document.querySelector('#due-date').value = '';
    document.querySelector('#priority').value = '';
    document.querySelector('#status').value = '';  // Reset status
}

function addTask(task, dueDate, priority, status) {
    fetch('http://localhost/finalv2/controllers/TodoController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'task': task,
            'due_date': dueDate,
            'priority': priority,
            'status': status,  
            'list_id': window.global.selectedListId,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateTaskList();
                resetTaskForm();
            } else {
                console.log('Error adding task');
            }
        })
        .catch(error => {
            console.log('An error occurred:', error);
        });
}

function deleteTask(id) {
    fetch(`http://localhost/finalv2/controllers/TodoController.php`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'id': id
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateTaskList();
            } else {
                console.log('Error deleting task');
            }
        })
        .catch(error => {
            console.log('An error occurred:', error);
        });
}

function editTask(id) {
    fetch(`http://localhost/finalv2/controllers/TodoController.php?id=${id}`, {
        method: 'GET',
    })
        .then(response => response.json())
        .then(task => {
            document.querySelector('#add-todo').value = task.tasks;
            document.querySelector('#due-date').value = task.due_date;
            document.querySelector('#priority').value = task.priority;
            document.querySelector('#status').value = task.status; 

            const addTodoBtn = document.querySelector('#add-todo-btn');
            addTodoBtn.textContent = 'Update';
            addTodoBtn.dataset.id = id;
        })
        .catch(error => {
            console.log('An error occurred:', error);
        });
}

function updateTask(id, task, due_date, priority, status) {
    if (!task || !due_date || !priority || !status) {
        alert("Please fill out all fields.");
        return;
    }

    fetch(`http://localhost/finalv2/controllers/TodoController.php`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'id': id,
            'task': task,
            'due_date': due_date,
            'priority': priority,
            'status': status,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateTaskList();
                resetTaskForm();
                const addTodoBtn = document.querySelector('#add-todo-btn');
                addTodoBtn.textContent = 'Add';
                delete addTodoBtn.dataset.id;
            } else {
                console.log('Error updating task');
            }
        })
        .catch(error => {
            console.log('An error occurred:', error);
        });
}

document.querySelector('#add-todo-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const task = document.querySelector('#add-todo').value;
    const dueDate = document.querySelector('#due-date').value;
    const priority = document.querySelector('#priority').value;
    const status = document.querySelector('#status').value; 

    const addTodoBtn = document.querySelector('#add-todo-btn');
    const id = addTodoBtn.dataset.id;

    if (id) {
        updateTask(id, task, dueDate, priority, status);
    } else {
        if (task && dueDate && priority && status) { 
            addTask(task, dueDate, priority, status); 
        } else {
            alert('Please fill in all fields');
        }
    }
});




