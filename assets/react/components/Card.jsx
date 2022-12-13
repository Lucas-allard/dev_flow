import React, {useEffect, useRef, useState} from 'react';
import Fade from "./Fade";
import rank from "../../image/Rank_set1/Rank_High/rank_high_18.png";

const Card = ({heading, children,}) => {
    const cardRef = useRef();
    const [isVisible, setIsVisible] = useState(false);
    const ratio = 0.05;

    const callbackFunction = (entries, observer) => {
        entries.forEach(entry => {
            if (cardRef.current && (entry.intersectionRatio > ratio)) {
                console.log("hello")
                setIsVisible(true)
                observer.unobserve(cardRef.current)
            }
        })
    }

    const options = {
        root: null,
        rootMargin: "0px",
        threshold: 1.0
    };

    useEffect(() => {
        const observer = new IntersectionObserver(callbackFunction, options)
        if (cardRef.current) observer.observe(cardRef.current)
    }, [cardRef, options])

    return (
        <Fade
            visible={isVisible}
            duration={300}

        >
            <div
                className="badge-card"
                ref={cardRef}
            >
                <div className="card">
                    <div className="feature-overview">
                        <div className="template">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div className="badge-detail">
                        <h3>{heading}</h3>
                        <div>
                            <img src={rank} alt=""/>
                        </div>
                    </div>
                </div>
                {children}
            </div>
        </Fade>
    );
}

export default Card;