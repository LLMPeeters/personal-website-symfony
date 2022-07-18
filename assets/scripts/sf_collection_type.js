class CollectionForm {
    prototype = null;
    target = null;
    addButton = null;
    deleteButton = null;
    fieldCount = 0;
	clone = null;

    constructor(target, attribute) {
        this.prototype = target.getAttribute(attribute);
		target.removeAttribute(attribute);
		
        this.target = target;

		this.target.innerHTML = this.prototype;
		
		this.clone = this.target.querySelector(`:scope > *`).cloneNode(true);
		
		this.setIndex(this.target.querySelector(`:scope > *`));
		
		this.createButtons();
		
		this.target.insertAdjacentElement(`afterend`, this.addButton);
		this.addButton.insertAdjacentElement(`afterend`, this.deleteButton);
    }
	
	getNewField() {
		return this.setIndex(this.clone.cloneNode(true));
	}
	
	createButtons() {
		const addButton = document.createElement(`button`);
		const deleteButton = document.createElement(`button`);
		const target = this.target;
		const thisHelper = this;
		
		addButton.innerText = `add`;
		deleteButton.innerText = `delete`;
		
		addButton.addEventListener(`click`, function(e) {
			e.preventDefault();
			
			const newField = thisHelper.getNewField();
			
			target.insertAdjacentElement(`beforeend`, newField);
		});
		
		deleteButton.addEventListener(`click`, function(e) {
			e.preventDefault();
			
			target.querySelector(`:scope > *:last-child`).remove();
		});
		
		this.addButton = addButton;
		this.deleteButton = deleteButton;
	}

    setIndex(element) {
		const elements = [element];
		
		for(const item of elements) {
			for(const child of item.querySelectorAll(`:scope > *`)) {
				elements.push(child);
			}
			
			const attributeNames = item.getAttributeNames();
			
			for(const name of attributeNames) {
				if(item.getAttribute(name).includes(`__name__`)) {
					item.setAttribute(
						name,
						item.getAttribute(name).replaceAll(`__name__`, this.fieldCount)
					);
				}
			}
		}
        
		this.fieldCount++;
        return element;
    }
}

const FormManager = {
    forms: [],

    init(options) {
        const collectionForms = document.querySelectorAll(`[${options.targetAttribute}]`);

        for(const form of collectionForms) {
            this.forms.push(
                new CollectionForm(form, options.targetAttribute)
            );
        }
    }
};

FormManager.init({
    targetAttribute: `data-prototype`,
});