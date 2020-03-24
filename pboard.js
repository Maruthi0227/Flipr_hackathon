var KanbanTest = new jKanban({
        element : '#myKanban',
        gutter  : '10px',
        click : function(el){
            alert(el.innerHTML);
            alert(el.dataset.eid)
        },
        boards  :[
            {
                'id' : '_todo',
                'title'  : 'To Do (drag me)',
                'class' : 'info',
                'item'  : [
                    {
                       'id':'task-1',
                        'title':'Try drag me',
                    },
                    {
                       'id':'task-2',
                        'title':'Click me!!',
                    }
                ]
            },
            {
                'id' : '_working',
                'title'  : 'Working',
                'class' : 'warning',
                'item'  : [
                    {
                        'title':'Do Something!',
                    },
                    {
                        'title':'Run?',
                    }
                ]
            },
            {
                'id' : '_done',
                'dragTo' : ['_working'],
                'title'  : 'Done (Drag only in Working)',
                'class' : 'success',
                'item'  : [
                    {
                        'title':'All right',
                    },
                    {
                        'title':'Ok!',
                    }
                ]
            }
        ]
    });

    var toDoButton = document.getElementById('addToDo');
    toDoButton.addEventListener('click',function(){
        KanbanTest.addElement(
            '_todo',
            {
                'title':'Test Add',
            }
        );
    });

    var addBoardDefault = document.getElementById('addDefault');
    addBoardDefault.addEventListener('click', function () {
        KanbanTest.addBoards(
            [{
                'id' : '_default',
                'title'  : 'NEW (Can\'t drop in Done)',
                'dragTo':['_todo','_working'],
                'class' : 'error',
                'item'  : [
                    {
                        'title':'Default Item',
                    },
                    {
                        'title':'Default Item 2',
                    },
                    {
                        'title':'Default Item 3',
                    }
                ]
            }]
        )
    });

    var removeBoard = document.getElementById('removeBoard');
    removeBoard.addEventListener('click',function(){
        KanbanTest.removeBoard('_done');
    });