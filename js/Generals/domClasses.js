class listOfCourses {
    constructor(origin, destination) {
        this.origin = origin;
        this.destination = destination;
    }
    render(items) {
        this.destination.appendChild(items);
    }
    setOrigin(origin) {
        this.origin = origin;
    }
    setDestination(dest) {
        this.destination = dest;
    }
}
class Course {
    constructor(title, description, price) {
        this.title = document.createElement("h4");

        //Asignar valores
        this.title.textContent = title;
        this.description = description;
        this.price = price;
        //asignar clases

    }

    create() {
        //returns DOM Element
    }
    // <div class="row">
    // <div class="col">
    //     <div class="card text-start">
    //         <img class="card-img-top" src="holder.js/100px180/" alt="Title">
    //             <div class="card-body">
    //                 <h4 class="card-title">Title</h4>
    //                 <p class="card-text">Body</p>
    //             </div>
    //     </div>

    // </div>

}