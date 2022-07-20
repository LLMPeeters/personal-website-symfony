class CollectionForm {
    prototype = null;
    target = null;
    addButton = null;
    fieldCount = 0;
	clone = null;
	fields = [];

    constructor(target, attribute) {
        this.prototype = target.getAttribute(attribute);
		target.removeAttribute(attribute);
        this.target = target;
		this.target.innerHTML = this.prototype;
		
		this.initFirstField(this.target.querySelector(`:scope > *`));
		
		this.createButtons();
		
		this.addButton = this.createAddButton();
		
		this.target.insertAdjacentElement(`afterend`, this.addButton);
    }
	
	createMoveButtons(targetToMove) {
		const upButton = document.createElement(`button`);
		const downButton = document.createElement(`button`);
		const target = targetToMove;
		const thisHelper = this;
		
		upButton.innerText = `up`;
		downButton.innerText = `down`;
		
		upButton.addEventListener(`click`, function(e) {
			e.preventDefault();
			
			const children = Array.from(target.parentNode.querySelectorAll(`:scope > *`));
			const index = children.indexOf(target);
			
			if(index > 0) {
				children[index-1].insertAdjacentElement(`beforebegin`, target);
				thisHelper.resetIndexes();
			}
		});
		
		downButton.addEventListener(`click`, function(e) {
			e.preventDefault();
			
			const children = Array.from(target.parentNode.querySelectorAll(`:scope > *`));
			const index = children.indexOf(target);
			
			if(index < children.length-1) {
				children[index+1].insertAdjacentElement(`afterend`, target);
				thisHelper.resetIndexes();
			}
		});
		
		return [upButton, downButton];
	}
	
	getNewField(inputField = null) {
		const field = inputField ?? this.clone.cloneNode(true);
		const removeButton = this.createRemoveButton(field);
		const moveButtons = this.createMoveButtons(field);
		
		for(const button of moveButtons) {
			field.insertAdjacentElement(`beforeend`, button);
		}
		
		this.setIndex(field);
		field.insertAdjacentElement(`beforeend`, removeButton);
		this.fields.push(field);
		
		return field;
	}
	
	initFirstField(field) {
		const elements = [field];
		
		for(const item of elements) {
			for(const child of item.querySelectorAll(`:scope > *`)) {
				elements.push(child);
			}
			
			const attributeNames = item.getAttributeNames();
			
			for(const name of attributeNames) {
				if(item.getAttribute(name).includes(`__name__`)) {
					item.setAttribute(
						`old.${name}`,
						item.getAttribute(name)
					)
				}
			}
		}
		
		this.clone = field.cloneNode(true);
		
		this.getNewField(field);
	}
	
	createAddButton() {
		const addButton = document.createElement(`button`);
		const target = this.target;
		const thisHelper = this;
		
		addButton.innerText = `add`;
		addButton.addEventListener(`click`, function(e) {
			e.preventDefault();
			
			const newField = thisHelper.getNewField();
			
			target.insertAdjacentElement(`beforeend`, newField);
		});
		
		return addButton;
	}
	
	createRemoveButton(targetToRemove) {
		const removeButton = document.createElement(`button`);
		const target = targetToRemove;
		
		removeButton.innerText = `remove`;
		removeButton.addEventListener(`click`, function(e) {
			e.preventDefault();
			
			target.remove();
		});
		
		return removeButton;
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
	
	resetIndexes() {
		const fields = this.fields[0].parentNode.querySelectorAll(`:scope > *`);
		
		this.fieldCount = 0;
		
		for(const field of fields) {
			this.setIndex(field, true);
		}
	}

    setIndex(element, reset = null) {
		const elements = [element];
		
		for(const item of elements) {
			for(const child of item.querySelectorAll(`:scope > *`)) {
				elements.push(child);
			}
			
			const attributeNames = item.getAttributeNames();
			
			for(const name of attributeNames) {
				if(reset) {
					const oldName = `old.${name}`;
					const oldValue = item.getAttribute(oldName);
					
					if(oldValue) {
						item.setAttribute(name, oldValue);
					}
				}
				
				if(name.slice(0, 4) !== `old.` && item.getAttribute(name).includes(`__name__`)) {
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