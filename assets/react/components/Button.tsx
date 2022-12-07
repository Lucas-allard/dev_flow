import React, {FunctionComponent, ReactNode} from 'react';
import './button.scss'

type Props = {
    className: string,
    route: string,
    children: ReactNode,
}

const Button: FunctionComponent<Props> = ({className, route, children}) => {
    return (
        <div>
            <a href={route} className={`button ${className ? className : ""}`}>{children}</a>
        </div>
    );
}

export default Button;