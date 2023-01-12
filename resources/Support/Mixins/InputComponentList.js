export default {
    components: {
        TextInputComponent: () => import('../Components/Forms/Inputs/TextInput.vue'),
        FileInputComponent: () => import('../Components/Forms/Inputs/FileInput.vue'),
        SelectInputComponent: () => import('../Components/Forms/Inputs/SelectInput.vue'),
        NumberInputComponent: () => import('../Components/Forms/Inputs/NumberInput.vue'),
        CustomInputComponent: () => import('../Components/Forms/Inputs/CustomInput.vue'),
        ComboboxInputComponent: () => import('../Components/Forms/Inputs/ComboboxInput.vue'),
        PasswordInputComponent: () => import('../Components/Forms/Inputs/PasswordInput.vue'),
        CheckboxInputComponent: () => import('../Components/Forms/Inputs/CheckboxInput.vue'),
        TextareaInputComponent: () => import('../Components/Forms/Inputs/TextareaInput.vue'),
        ConditionInputComponent: () => import('../Components/Forms/Inputs/ConditionInput.vue'),
        CodeEditorInputComponent: () => import('../Components/Forms/Inputs/CodeEditorInput.vue'),
        TimePickerInputComponent: () => import('../Components/Forms/Inputs/TimePickerInput.vue'),
        DatePickerInputComponent: () => import('../Components/Forms/Inputs/DatePickerInput.vue'),
        RichTextareaInputComponent: () => import('../Components/Forms/Inputs/RichTextareaInput.vue'),
        GroupCheckboxInputComponent: () => import('../Components/Forms/Inputs/GroupCheckboxInput.vue'),
        DatetimePickerInputComponent: () => import('../Components/Forms/Inputs/DatetimePickerInput.vue'),
        OneTimePasswordInputComponent: () => import('../Components/Forms/Inputs/OneTimePasswordInput.vue'),
    }
}
