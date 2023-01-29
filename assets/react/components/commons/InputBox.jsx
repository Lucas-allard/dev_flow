import './inputBox.scss';
import React from 'react';

function InputBox({type, value, label, register, error}) {
    return (
        <div className="inputBox">
            <input {...register} type={type} defaultValue={value}/>
            {error && <span className="error">{error.message}</span>}
            <span>{label}</span>
            <i></i>
        </div>
    );
}

export default InputBox;