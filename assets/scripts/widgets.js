var ProgressWidget = {
	percentageAttribute: null,
	barClass: null,
	targets: [],
	
	setBars() {
		for(const target of this.targets) {
			const containers = target.querySelectorAll(`[${this.percentageAttribute}]`);
			
			for(const container of containers) {
				const percentage = container.getAttribute(this.percentageAttribute);
				const bar = container.querySelector(`.${this.barClass}`);
				console.log(container);
				bar.style.width = `${percentage}%`;
			}
		}
	},
	
	init(options) {
		this.percentageAttribute = options.percentageAttribute;
		this.barClass = options.barClass;
		
		this.targets = document.querySelectorAll(`.${options.targetClass}`);
		
		this.setBars();
	}
};

ProgressWidget.init({
	targetClass: `progress-widget`,
	percentageAttribute: `progress`,
	barClass: `bar`,
});