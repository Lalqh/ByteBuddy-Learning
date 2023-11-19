import { convertToInput } from './functions.js';
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
}
class Course {
    constructor(id, title, description, price) {
        this.title = document.createElement("h4");
        this.col = document.createElement('div');
        this.card = document.createElement('div');
        this.cardBody = document.createElement('div');
        this.description = document.createElement('p');
        this.price = document.createElement('p');
        //Asignar valores
        this.title.textContent = title;
        this.description.textContent = description;
        this.price.textContent = price;
        //Asignar ids
        this.col.id = "id" + id;
        this.title.id = "title" + id;
        this.price.id = "price" + id;
        this.description.id = "description" + id;
        //asignar clases
        this.title.classList.add('card-title');
        this.description.classList.add('card-text');
        this.col.classList.add('col', 'mb-3');
        this.card.classList.add('card', 'text-start');
        this.cardBody.classList.add('card-body');
        this.price.classList.add('card-text', 'price');
        //Asignar eventos
        this.description.addEventListener('click', () => convertToInput(this.description));
        this.price.addEventListener('click', () => convertToInput(this.price));
        this.title.addEventListener('click', () => convertToInput(this.title));

        //agregar a la columna de cards
        this.col.append(this.card);
        this.card.append(this.cardBody);
        this.cardBody.append(this.title);
        this.cardBody.append(this.description);
        this.cardBody.append(this.price);


    }

    create() {
        //returns DOM Element
        return this.col;
    }

}