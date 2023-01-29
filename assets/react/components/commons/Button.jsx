import React from 'react';
import './button.scss'


const Button = ({className, route, children}) => {
    return (
        <div>
            <a href={route} className={`button ${className ? className : ""}`}>{children}</a>
        </div>
    );
}

export default Button;