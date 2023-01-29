import './textareaBox.scss';
import React from 'react';

function TextareaBox({value, label, register, error}) {
    return (
        <div className="textareaBox">
            <textarea {...register} value={value}/>
            {error && <span className="error">{error.message}</span>}
            <span>{label}</span>
            <i></i>
        </div>
    );
}

export default TextareaBox;