import './gamificationSection.scss';
import React from 'react';
import Card from "../components/Card";

const GamificationSection = () => {
    return (
        <section className="container">
            <div className="gamification-section">
                <h2>Apprends, participe et aide d'autres personnes pour gagner des badges</h2>
                <div className="badges-overview">
                    <Card heading={"Termine le plus de cours"}>
                        <div className="content">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit.
                                Aperiam cumque dignissimos
                                doloremque eos est illo, incidunt libero modi molestiae nemo pariatur porro quam,
                                quia
                                quo repellendus sint tempore unde voluptas.
                            </p>

                        </div>
                    </Card>
                    <Card heading={"Termine le plus de cours"}>
                        <div className="content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit.
                                Aperiam cumque dignissimos
                                doloremque eos est illo, incidunt libero modi molestiae nemo pariatur porro quam,
                                quia
                                quo repellendus sint tempore unde voluptas.</p>
                        </div>
                    </Card>
                    <Card heading={"Termine le plus de cours"}>
                        <div className="content">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing
                                elit.
                                Aperiam cumque dignissimos
                                doloremque eos est illo, incidunt libero modi molestiae nemo pariatur porro quam,
                                quia
                                quo repellendus sint tempore unde voluptas.
                            </p>
                        </div>
                    </Card>
                </div>
            </div>
        </section>
    );
}

export default GamificationSection;