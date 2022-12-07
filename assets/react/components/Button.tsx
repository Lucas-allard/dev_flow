import React, {ReactNode} from 'react';
import './button.scss'

type ButtonProps = {
    className: string,
    route: string,
    children: ReactNode,
}

function Button({className, route, children}: ButtonProps) {
    return (
        <div>
            <a href={route} className={`button ${className ? className : ""}`}>{children}</a>
        </div>
    );
}

export default Button;