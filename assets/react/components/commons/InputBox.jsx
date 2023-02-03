import './inputBox.scss';
import React from 'react';

function InputBox({type, value, label, register, error}) {
    return (
        <div className="inputBox">
            <input
                {...register}
                type={type}
                defaultValue={value}
                accept={
                    type === "file" ?
                        "image/png, image/jpeg, image/jpg, image/gif"
                        : null}
            />
            {type === "file" && <button disabled={true}>Choisir un fichier</button>}
            {error && <span className="error">{error.message}</span>}
            <span>{label}</span>
            <i></i>
        </div>
    );
}

export default InputBox;