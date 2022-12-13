import './heroSection.scss';
import React from 'react';
import Button from "../components/Button";
import {FaGithub, FaLinkedinIn} from "react-icons/fa";
import {BiMessageAltDetail} from "@react-icons/all-files/bi/BiMessageAltDetail";
import logoBlack from "../../image/logo-dev-flow-black.png"
import ScrollDown from "../components/ScrollDown";
import AnimatedText from "react-animated-text-content";


const HeroSection = () => {

    return (
        <section className="container bg-white init-width position-relative">
            <div className="container">
                <div className='hero-section'>
                    <div className="hero-header">
                        <h2>Bienvenu sur Web Flow, le blog d'un passionné pour les passionnés</h2>
                        <div>
                            <img
                                src={logoBlack} alt="Logo Dev Flow"
                            />
                        </div>
                    </div>
                    <div className='hero-content'>
                        <span style={{display: "block", padding: "4rem"}}>
                            <AnimatedText
                                type='words'
                                interval={0.1}
                                duration={0.5}
                                animation={{
                                    y: '100px',
                                    ease: 'ease',
                                }}
                            >Texte de présentation sur moi : Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Ad
                            alias consectetur et ex laboriosam magnam molestias officiis perspiciatis repudiandae.
                            Ab
                            consectetur eligendi expedita facere ipsa iure molestias nulla reiciendis sapiente.
                        </AnimatedText>
                        </span>
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
            </div>
        </section>
    );
}

export default HeroSection;