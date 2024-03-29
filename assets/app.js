/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/normalize.css'
import './styles/app.scss';
import './styles/header.scss';
import './styles/form.scss';
import './styles/labo.scss';
import './styles/pagination.scss';
import './styles/searchForm.scss';
import './styles/course.scss';
import './styles/challenges.scss';
import './styles/challenge.scss';



// start the Stimulus application
import './bootstrap';
import {registerReactControllerComponents} from "@symfony/ux-react";

registerReactControllerComponents(require.context('./react/controllers', false, /\.(j|t)sx?$/));
