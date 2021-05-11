<div
	class="form-group row align-items-center"
	:class="{'has-danger': errors.has('project_id'), 'has-success': fields.project_id && fields.project_id.valid }"
>
	<label
		for="project_id"
		class="col-form-label text-md-right"
		:class="isFormLocalized ? 'col-md-4' : 'col-md-2'"
	>
		Project
	</label>

	<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
		<multiselect
			v-model="form.project_id"
			:options="projects"
			:multiple="false"
			track-by="id"
			label="name"
			placeholder="Select a project"
		>
		</multiselect>

		<div
			v-if="errors.has('project_id')"
			class="form-control-feedback form-text"
			v-cloak
		>
			@{{ errors.first('project_id') }}
		</div>
	</div>
</div>

<div
	class="form-group row align-items-center"
	:class="{'has-danger': errors.has('task'), 'has-success': fields.task && fields.task.valid }"
>
	<label
		for="task"
		class="col-form-label text-md-right"
		:class="isFormLocalized ? 'col-md-4' : 'col-md-2'"
	>
		Task
	</label>

	<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
		<div>
			<textarea
				class="form-control"
				v-model="form.task"
				id="task"
				name="task"
			></textarea>
		</div>

		<div
			v-if="errors.has('task')"
			class="form-control-feedback form-text"
			v-cloak
		>
			@{{ errors.first('task') }}
		</div>
	</div>
</div>

<div
	class="form-group row align-items-center"
	:class="{'has-danger': errors.has('description'), 'has-success': fields.description && fields.description.valid }"
>
	<label
		for="description"
		class="col-form-label text-md-right"
		:class="isFormLocalized ? 'col-md-4' : 'col-md-2'"
	>
		Description
	</label>

	<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
		<div>
			<wysiwyg
				v-model="form.description"
				id="description"
				name="description"
				:config="mediaWysiwygConfig"
			></wysiwyg>
		</div>

		<div
			v-if="errors.has('description')"
			class="form-control-feedback form-text"
			v-cloak
		>
			@{{ errors.first('description') }}
		</div>
	</div>
</div>

<div
	class="form-group row align-items-center"
	:class="{'has-danger': errors.has('start_date'), 'has-success': fields.start_date && fields.start_date.valid }"
>
	<label
		for="start_date"
		class="col-form-label text-md-right"
		:class="isFormLocalized ? 'col-md-4' : 'col-md-2'"
	>
		Start date
	</label>

	<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
		<div class="input-group input-group--custom">
			<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			
            <datetime
				v-model="form.start_date"
				:config="datetimePickerConfig"
				class="flatpickr"
				id="start_date"
				name="start_date"
				placeholder="Select a date time"
			>
			</datetime>
		</div>

		<div
			v-if="errors.has('start_date')"
			class="form-control-feedback form-text"
			v-cloak
		>
			@{{ errors.first('start_date') }}
		</div>
	</div>
</div>

<div
	class="form-group row align-items-center"
	:class="{'has-danger': errors.has('minutes'), 'has-success': fields.minutes && fields.minutes.valid }"
>
	<label
		for="minutes"
		class="col-form-label text-md-right"
		:class="isFormLocalized ? 'col-md-4' : 'col-md-2'"
		>Minutes</label
	>

	<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
		<input
			type="text"
			v-model="form.minutes"
			class="form-control"
			id="minutes"
			name="minutes"
			placeholder="Minutes"
			v-validate="'decimal'"
		/>

		<div
			v-if="errors.has('minutes')"
			class="form-control-feedback form-text"
			v-cloak
		>
			@{{ errors.first('minutes') }}
		</div>
	</div>
</div>

<div
	class="form-group row align-items-center"
	:class="{'has-danger': errors.has('location'), 'has-success': fields.location && fields.location.valid }"
>
	<label
		for="location"
		class="col-form-label text-md-right"
		:class="isFormLocalized ? 'col-md-4' : 'col-md-2'"
	>
		Location
	</label>

	<div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
		<div>
            <select class="form-control" v-model="form.location" id="location" name="location">
                <option :value="null">Select a location</option>
                <option value="work">Working place</option>
                <option value="home">Remote</option>
                <option value="client">Client</option>
            </select>
		</div>

		<div
			v-if="errors.has('location')"
			class="form-control-feedback form-text"
			v-cloak
		>
			@{{ errors.first('location') }}
		</div>
	</div>
</div>
