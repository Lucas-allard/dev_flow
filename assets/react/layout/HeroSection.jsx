import './heroSection.scss';
import React from 'react';
import Button from "../components/Button";
import {FaGithub, FaLinkedinIn} from "react-icons/fa";
import {BiMessageAltDetail} from "@react-icons/all-files/bi/BiMessageAltDetail";
import logoBlack from "../../image/logo-dev-flow-black.png"
import ScrollDown from "../components/ScrollDown";


const HeroSection = () => {

    return (
        <section className="hero-section-bg">
            <div className='hero-section'>
                <div className="hero-header">
                    <h2>Bienvenu sur Web Flow, <br/>
                        le blog d'un passionné pour les passionnés</h2>
                </div>
                <div className='hero-content'>
                    <p>
                        Texte de présentation sur moi : Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Ad
                        alias consectetur et ex laboriosam magnam molestias officiis perspiciatis repudiandae.
                        Ab
                        consectetur eligendi expedita facere ipsa iure molestias nulla reiciendis sapiente.

                    </p>
                    <p>
                        Texte de présentation sur moi : Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Ad
                        alias consectetur et ex laboriosam magnam molestias officiis perspiciatis repudiandae.
                        Ab
                        consectetur eligendi expedita facere ipsa iure molestias nulla reiciendis sapiente.

                    </p>
                    <div className="hero-helpers">
                        <Button className="button-cta"
                                route={'https://www.linkedin.com/in/lucasallard97/'}><FaLinkedinIn/></Button>
                        <Button className="button-cta"
                                route={'https://github.com/Lucas-allard'}><FaGithub/></Button>
                        <Button className="button-cta" route={"/contact"}><BiMessageAltDetail/></Button>
                        <Button className="button-cta" route={"/auteur"}>En savoir plus sur l'auteur</Button>
                    </div>
                </div>
            </div>
            <ScrollDown
                path="last-content-section"
                className={null}
            />
        </section>
    );
}

export default HeroSection;