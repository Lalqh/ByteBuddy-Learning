import { convertToInput } from './functions.js';
import { postData } from './requests.js';
export class listOfCourses {
    constructor(destination) {
        this.destination = destination;
    }
    render(items) {
        items.forEach(element => {
            let course = new Course(element.id, element.nombre, element.descripcion, element.precio);
            this.destination.appendChild(course.create());
        });
    }
    setDestination(dest) {
        this.destination = dest;
    }
    appendCourse(course) {
        this.destination.appendChild(course.create())
    }
}
export class Course {
    constructor(id, title, description, price) {
        this.id = id;
        this.title = document.createElement("h4");
        this.col = document.createElement('div');
        this.card = document.createElement('div');
        this.cardBody = document.createElement('div');
        this.description = document.createElement('p');
        this.price = document.createElement('p');
        this.deleteButton = document.createElement('button');
        //Asignar valores
        this.title.textContent = title;
        this.description.textContent = description;
        this.price.textContent = price;
        this.deleteButton.textContent = 'Eliminar';
        //Asignar ids
        this.card.setAttribute('course_id', id);
        this.cardBody.setAttribute('course_id', id);
        this.col.setAttribute('course_id', id);
        this.title.setAttribute('course_id', id);
        this.price.setAttribute('course_id', id);
        this.description.setAttribute("course_id", id);
        this.deleteButton.setAttribute('course_id', id);
        //asignar clases
        this.title.classList.add('card-title');
        this.description.classList.add('card-text');
        this.col.classList.add('col', 'mb-3');
        this.card.classList.add('card', 'text-start');
        this.cardBody.classList.add('card-body');
        this.price.classList.add('card-text', 'price');
        this.deleteButton.classList.add('btn', 'btn-danger');
        //Asignar eventos
        this.description.addEventListener('click', () => convertToInput(this.description));
        this.price.addEventListener('click', () => convertToInput(this.price));
        this.title.addEventListener('click', () => convertToInput(this.title));
        this.deleteButton.addEventListener('click', () => this.deleteCourse());
        //otros atributos
        this.description.setAttribute('column', 'descripcion');
        this.price.setAttribute('column', 'precio');
        this.title.setAttribute('column', 'nombre');
        //agregar a la columna de cards
        this.col.append(this.card);
        this.card.append(this.cardBody);
        this.cardBody.append(this.title);
        this.cardBody.append(this.description);
        this.cardBody.append(this.price);
        this.cardBody.append(this.deleteButton);


    }

    create() {
        //returns DOM Element
        return this.col;
    }
    getNode() {
        return this.col;
    }
    deleteCourse() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar curso!'
        }).then((result) => {
            let deleteData = new FormData();
            const destination = document.querySelector('#courses');
            deleteData.append('req', 'delete_course');
            deleteData.append('id', this.id);
            if (result.isConfirmed) {
                postData('../../models/courses.php', deleteData)
                    .then((resp) => {
                        if (resp.code === "ok") {
                            Swal.fire(
                                'Eliminado!',
                                'Curso eliminado con éxito.',
                                'success'
                            )
                            destination.removeChild(this.getNode());
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: resp.message,
                                icon: 'error',
                                customClass: 'swal-wide',
                            })
                        }
                    })
            }
        })
    }

}

export class UserCourse {
    constructor(id, title, description) {
        this.id = id;
        this.carouselItem = document.createElement('div');
        this.card = document.createElement('div');
        this.imgWrapper = document.createElement('div');
        this.img = document.createElement('img');
        this.cardBody = document.createElement('div');
        this.title = document.createElement("h5");
        this.description = document.createElement('p');
        this.showMoreButton = document.createElement('a');
        //Asignar valores
        this.title.textContent = title;
        this.description.textContent = description;
        this.img.src = "";
        this.showMoreButton.textContent = "Ver mas";
        this.showMoreButton.href = "./producto.html?curso_id=" + this.id;
        //Asignar ids
        this.carouselItem.setAttribute('course_id', id);
        this.card.setAttribute('course_id', id);
        this.imgWrapper.setAttribute('course_id', id);
        this.cardBody.setAttribute('course_id', id);
        this.title.setAttribute('course_id', id);
        this.description.setAttribute("course_id", id);
        this.showMoreButton.setAttribute('course_id', id);
        //asignar clases
        this.carouselItem.classList.add('carousel-item', 'active');
        this.imgWrapper.classList.add('img-wrapper');
        this.img.width = 200;
        this.img.classList.add('img-fluid');
        this.title.classList.add('card-title');
        this.description.classList.add('card-text');
        this.card.classList.add('card', 'text-start');
        this.cardBody.classList.add('card-body');
        this.showMoreButton.classList.add('btn', 'btn-primary');
        //Asignar eventos

        //otros atributos

        this.title.setAttribute('column', 'nombre');
        //agregar a la columna de cards
        this.carouselItem.append(this.card);
        this.card.append(this.imgWrapper);
        this.imgWrapper.append(this.img);
        this.card.append(this.cardBody);
        this.cardBody.append(this.title);
        this.cardBody.append(this.description);
        this.cardBody.append(this.showMoreButton);


    }

    create() {
        return this.carouselItem;
    }
    setId(id) {
        this.id = id;
    }
    setImage(src) {
        this.img.src = src;
    }
}
export class listOfUserCourses {
    constructor(destination) {
        this.destination = destination;
    }
    render(items) {
        items.forEach(element => {
            let course = new UserCourse(element.id, element.nombre, element.descripcion);
            course.setImage(element.img_src);
            this.destination.appendChild(course.create());
        });
    }
    setDestination(dest) {
        this.destination = dest;
    }
    appendCourse(course) {
        this.destination.appendChild(course.create())
    }
}