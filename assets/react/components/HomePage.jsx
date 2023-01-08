import React from 'react';
import HeroSection from '../layout/HeroSection';
import LastContentSection from "../layout/LastContentSection";
import GamificationSection from "../layout/GamificationSection";


export const HomePage = () => {
    return (
            <main>
                <HeroSection/>
                <LastContentSection/>
                {/*<GamificationSection/>*/}
            </main>
    );
}

export default HomePage;