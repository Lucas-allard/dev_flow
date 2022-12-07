import './lastContentSection.scss';
import React from 'react';
import Button from "../components/Button";
import * as logoJS from '../../image/logo-js.png';
import * as logoHTML from '../../image/logo-html.png';
import * as logoCSS from '../../image/logo-css.png';
import ScrollDown from "../components/ScrollDown";
import AnimatedText from "react-animated-text-content";
import CodeRain from "../components/RainStream/CodeRain";

const LastContentSection = () => {
    // @ts-ignore
    return (
        <section className="container init-width position-relative" id="last-content-section">
            <CodeRain/>
            <div className="home-section">
                <div className="home-header">
                    <div className="cta">
                        <h2>
                            <AnimatedText
                                type='words'
                                interval={0.04}
                                duration={0.8}
                                animation={{
                                    y: '100px',
                                    ease: 'ease',
                                }}
                            >
                                Dev Flow c'est une plateforme d'apprentissage mais c'est avant tout une plateforme
                                d'entraide
                                !
                            </AnimatedText>
                        </h2>
                        <div className="cta-register">
                            <Button className="button-cta code-rain" route="/inscription">S'inscrire</Button>
                            <Button className="button-cta code-rain" route='/labo'>Le Labo</Button>
                        </div>
                        <div className="cta-content">
                            <a href="#">
                                <AnimatedText
                                    type='chars'
                                    interval={0.04}
                                    duration={0.8}
                                    animation={{
                                        y: '100px',
                                        ease: 'ease',
                                    }}
                                >
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto
                                    asperiores delectus
                                    dicta ea exercitationem fugiat, illum iure laboriosam maxime porro quaerat, quisquam
                                    reprehenderit suscipit tempore ut veniam veritatis voluptatibus voluptatum.
                                </AnimatedText>
                            </a>
                        </div>
                    </div>
                </div>
                <div className="home-overview">
                    <div className="courses-overview">
                        <h3>
                            <a href="">Derniers cours</a>
                        </h3>
                        <div className="overview-content">
                            <a href="#">
                                <img src={logoHTML} alt="Catégorie HTML"/>
                            </a>
                            <div>
                                <a href="#"><p>Intitulé du cours</p></a>
                                <a href="#"><p><em>Durée de lecture du cours</em></p></a>
                            </div>
                        </div>
                        <div className="overview-content">
                            <a href="#">
                                <img src={logoCSS} alt="Catégorie CSS"/>
                            </a>
                            <div>
                                <a href="#"><p>Intitulé du cours</p></a>
                                <a href="#"><p><em>Durée de lecture du cours</em></p></a>
                            </div>
                        </div>
                        <div className="overview-content">
                            <a href="#">
                                <img src={logoJS} alt="Catégorie JS"/>
                            </a>
                            <div>
                                <a href="#"><p>Intitulé du cours</p></a>
                                <a href="#"><p><em>Durée de lecture du cours</em></p></a>
                            </div>
                        </div>
                    </div>
                    <div className="articles-overview">
                        <h3>
                            <a href="">Derniers articles</a>
                        </h3>
                        <div className="overview-content">
                            <a href="#">
                                <img src={logoHTML} alt="Catégorie HTML"/>
                            </a>
                            <div>
                                <a href="#"><p>Intitulé de l'article</p></a>
                                <a href="#"><p><em>Durée de lecture de l'article</em></p></a>
                            </div>
                        </div>
                        <div className="overview-content">
                            <a href="#">
                                <img src={logoCSS} alt="Catégorie CSS"/>
                            </a>
                            <div>
                                <a href="#"><p>Intitulé de l'article</p></a>
                                <a href="#"><p><em>Durée de lecture de l'article</em></p></a>
                            </div>
                        </div>
                        <div className="overview-content">
                            <a href="#">
                                <img src={logoJS} alt="Catégorie JS"/>
                            </a>
                            <div>
                                <a href="#"><p>Intitulé de l'article</p></a>
                                <a href="#"><p><em>Durée de lecture de l'article</em></p></a>
                            </div>
                        </div>
                    </div>
                    <div className="tricks-overview">
                        <h3>
                            <a href="">Derniers tricks</a>
                        </h3>
                        <div className="overview-content">
                            <a href="#">
                                <img src={logoHTML} alt="Catégorie HTML"/>
                            </a>
                            <div>
                                <a href="#"><p>Intitulé du tricks</p></a>
                                <a href="#"><p><em>Durée de lecture du tricks</em></p></a>
                            </div>
                        </div>
                        <div className="overview-content">
                            <a href="#">
                                <img src={logoCSS} alt="Catégorie CSS"/>
                            </a>
                            <div>
                                <a href="#"><p>Intitulé du tricks</p></a>
                                <a href="#"><p><em>Durée de lecture du tricks</em></p></a>
                            </div>
                        </div>
                        <div className="overview-content">
                            <a href="#">
                                <img src={logoJS} alt="Catégorie JS"/>
                            </a>
                            <div>
                                <a href="#"><p>Intitulé du tricks</p></a>
                                <a href="#"><p><em>Durée de lecture du tricks</em></p></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ScrollDown
                className="white"
                path="gamification-section"
            />
        </section>
    );
}

export default LastContentSection;