import './scrollDown.scss';
import React, {FunctionComponent} from 'react';
import {Link} from 'react-scroll';

type Props = {
    className: string | null,
    path: string,
}

const ScrollDown: FunctionComponent<Props> = ({className, path}) => {

    return (
        <Link
            to={path}
            spy={true}
            smooth={true}
            offset={0}
            duration={800}
        >
            <div className={`scroll-down-cta ${className ? className : ""}`}>
                <span></span>
            </div>
            <div className="info-cta">
                <p>Clique pour ScrollDown</p>
            </div>
        </Link>
    );
}

export default ScrollDown;