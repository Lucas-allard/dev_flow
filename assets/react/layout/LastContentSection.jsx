import './lastContentSection.scss';
import React from 'react';
import Button from "../components/commons/Button";
import logoJS from '../../image/logo-js.png';
import logoHTML from '../../image/logo-html.png';
import logoCSS from '../../image/logo-css.png';
import ScrollDown from "../components/commons/ScrollDown";

const LastContentSection = () => {
    return (
        <section id="last-content-section">
            <div className="home-section">
                <div className="home-header">
                    <div className="cta">
                        <h2>
                            Rejoignez la communauté Dev Flow et devenez un expert en développement web !
                        </h2>
                        <div className="cta-register">
                            <Button className="button-cta code-rain" route="/inscription">S'inscrire</Button>
                            <Button className="button-cta code-rain" route='/labo'>Le Labo</Button>
                        </div>
                        <div className="cta-content">
                            <p>
                                En vous inscrivant sur Dev Flow, vous aurez accès à une grande variété de cours,
                                tutoriels et autres ressources pour vous aider à devenir un développeur accompli. Et si
                                vous avez besoin de plus d'aide, vous pourrez également réserver un mentorat auprès de
                                l'un de nos mentors expérimentés.
                            </p>
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