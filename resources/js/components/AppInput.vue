<template>
    <div class="app-input rounded-s">
        <input 
            v-model="internalModel"
            class="app-input__field padding-m w-100"
            :class="inputClass"
            :type="type"
            :placeholder="placeholder"
            :disabled="disabled"
            @input="e => synchronized = (e.target.value == modelValue)"
            @focusout="rollbackInternalModel"
            @change="validateInternalModel"
        >
    </div>
</template>

<script>
export default {
    name: 'InputField',
    props: {
        type: String,
        modelValue: [String, Number],
        disabled: Boolean,
        modelModifiers: {
            default: () => ({})
        },
        placeholder: {
            type: String,
            default: '',
            required: false
        },
        validator: {
            type: Function,
            default: () => true,
            required: false
        },
        modelUpdated: {
            type: Function,
            default: () => {},
            required: false
        }
    },
    emits: ['update:modelValue'],
    data() {
        return {
            internalModel: this.modelValue,
            synchronized: true
        }
    },
    computed: {
        inputClass() {
            return [
                this.synchronized ? 'app-input__field--idle' : 'app-input__field--action',
                this.disabled ? 'cursor-not-allowed' : ''
            ]
        }
    },
    watch: {
        modelValue(value) {
            this.internalModel = value
        }
    },
    methods: {
        rollbackInternalModel() {
            this.synchronized = true
            this.internalModel = this.modelValue
        },
        validateInternalModel() {
            if(this.type == 'number' && isNaN(parseFloat(this.internalModel))) return
            if(this.validator(this.internalModel)) this.saveModelValue()
        },
        saveModelValue() {
            this.synchronized = true
            this.$emit('update:modelValue', this.internalModel)
            this.modelUpdated()
        }
    }
}
</script>

<style>
.app-input {
    background-color: var(--alt-bg-color);
    color: var(--alt-text-color);
}
.app-input__field  {
    outline: none;
    border: none;
    background: transparent;
    color: inherit;
    border-radius: inherit;
    font-family: inherit;
    line-break: 20px;
    font-size: 14px;
}
.app-input__field--idle {
    border: 1px solid var(--main-border-color);
}
.app-input__field--action {
    border: 1px solid var(--action-color);
}
</style>