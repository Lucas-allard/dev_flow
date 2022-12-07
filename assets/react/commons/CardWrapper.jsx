import "./cardWrapper.scss";
import React from 'react';

const CardWrapper = ({className, children}) => {
    return (
        <div className={`${className ? className : ""}`}>
            {children}
        </div>
    );
}

export default CardWrapper;