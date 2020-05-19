<?php
$session = Config\Services::session();
helper('form');
$message = $session->getFlashdata('message');
$error = $session->getFlashdata('error');

$titleOptions = [
    'mr' => 'Mr.',
    'mrs' => 'Mrs.',
    'miss' => 'Miss.',
    'dr' => 'Dr.'
];

?>
<style>
    .card-register {
        border-radius: 1rem;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-md-6 col-lg-5 mx-auto">
            <div class="card shadow-sm card-register my-5">
                <div class="card-body">
                    <h2 class="card-title text-center"><?= getenv('app.name'); ?></h2>
                    <h5 class="card-subtitle text-center font-weight-light">Register</h5>
                    <div id="root"></div>
                    <div id="root2"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>


<script type="text/babel">

    class BasicForm extends React.Component {
        constructor(props) {
            super(props);
            this.state = {
                firstName: '',
                lastName: '',
                title: '',
                phone: '',
                email: '',
                password: '',
                passwordConf: '',
                firstNameError: '',
                lastNameError: '',
                titleError: '',
                phoneError: '',
                emailError: '',
                passwordError: '',
                passwordConfError: ''
            };
        }

        handleFirstNameChange = event => {
            this.setState({firstName: event.target.value}, () => {
                this.validateFirstName();
            });
        };
        handleLastNameChange = event => {
            this.setState({lastName: event.target.value}, () => {
                this.validateLastName();
            });
        };
        handleTitleChange = event => {
            this.setState({title: event.target.value}, () => {
                this.validateTitle();
            });
        };
        handlePhoneChange = event => {
            this.setState({phone: event.target.value}, () => {
                this.validatePhone();
            });
        };
        handleEmailChange = event => {
            this.setState({email: event.target.value}, () => {
                this.validateEmail();
            });
        };
        handlePasswordChange = event => {
            this.setState({password: event.target.value}, () => {
                this.validatePassword();
            });
        };
        handlePasswordConfChange = event => {
            this.setState({passwordConf: event.target.value}, () => {
                this.validatePasswordConf();
            });
        };


        validateFirstName = () => {
            const {firstName} = this.state;
            if (firstName.length < 1) {
                this.setState({
                    firstNameError: 'First name must be at least 1 character.'
                });
            } else {
                this.setState({
                    firstNameError: ''
                });
            }
        }

        validateLastName = () => {
            const {lastName} = this.state;
            if (lastName.length < 1) {
                this.setState({
                    lastNameError: 'Last name must be at least 1 character.'
                });
            } else {
                this.setState({
                    lastNameError: ''
                });
            }
        }

        validateTitle = () => {
            const {title} = this.state;
            if (title.length < 1) {
                this.setState({
                    titleError: 'Title must be at least 1 character.'
                });
            } else {
                this.setState({
                    titleError: ''
                });
            }
        }

        validatePhone = () => {
            const {phone} = this.state;
            if (phone.length < 10) {
                this.setState({
                    phoneError: 'Phone must be 10 digits'
                });
            } else if (phone.length > 10) {
                this.setState({
                    phoneError: 'Phone must be 10 digits'
                });
            } else if (isNaN(phone)) {
                this.setState({
                    phoneError: 'Phone must be numeric.'
                });
            } else {
                this.setState({
                    phoneError: ''
                });
            }
        }


        validateEmail = () => {
            const {email} = this.state;
            if (/[A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,64}/.test(email)) {
                this.setState({
                    emailError: ''
                });
            } else {
                this.setState({
                    emailError: 'Email address is not a valid email address.'
                });
            }
        }

        validatePassword = () => {
            const {password} = this.state;
            if (password.length < 8) {
                this.setState({
                    passwordError: 'Your password must be at least 8 characters.'
                });
            } else {
                this.setState({
                    passwordError: ''
                });
            }
        }


        validatePasswordConf = () => {
            const {passwordConf} = this.state;
            if (!(passwordConf === this.state.password)) {
                this.setState({
                    passwordConfError: 'Your passwords must match.'
                });
            } else {
                this.setState({
                    passwordConfError: ''
                });
            }
        }

        handleSubmit = event => {
        };

        render() {
            return (
                <form onSubmit={this.handleSubmit} method='post'>
                    <div className='form-group'>
                        <label htmlFor='first_name'>Name</label>
                        <input
                            name='first_name'
                            className={`form-control ${this.state.firstNameError ? 'is-invalid' : ''}`}
                            id='name'
                            placeholder='Joe'
                            value={this.state.firstName}
                            onChange={this.handleFirstNameChange}
                            onBlur={this.validateFirstName}
                        />
                        <div className='invalid-feedback'>{this.state.firstNameError}</div>
                    </div>
                    <div className='form-group'>
                        <label htmlFor='last_name'>Last Name</label>
                        <input
                            name='last_name'
                            className={`form-control ${this.state.lastNameError ? 'is-invalid' : ''}`}
                            id='last_name'
                            placeholder='Bloggs'
                            value={this.state.lastName}
                            onChange={this.handleLastNameChange}
                            onBlur={this.validateLastName}
                        />
                        <div className='invalid-feedback'>{this.state.lastNameError}</div>
                    </div>
                    <div className='form-group'>
                        <label htmlFor='title'>Title</label>
                        <input
                            name='title'
                            className={`form-control ${this.state.titleError ? 'is-invalid' : ''}`}
                            id='title'
                            placeholder='Mr.'
                            value={this.state.title}
                            onChange={this.handleTitleChange}
                            onBlur={this.validateTitle}
                        />
                        <div className='invalid-feedback'>{this.state.titleError}</div>
                    </div>
                    <div className='form-group'>
                        <label htmlFor='phone'>Phone</label>
                        <input
                            name='phone'
                            className={`form-control ${this.state.phoneError ? 'is-invalid' : ''}`}
                            id='phone'
                            placeholder='7700900000'
                            value={this.state.phone}
                            onChange={this.handlePhoneChange}
                            onBlur={this.validatePhone}
                        />
                        <div className='invalid-feedback'>{this.state.phoneError}</div>
                    </div>
                    <div className='form-group'>
                        <label htmlFor='email'>Email</label>
                        <input
                            name='email'
                            className={`form-control ${this.state.emailError ? 'is-invalid' : ''}`}
                            id='email'
                            placeholder='Enter email'
                            value={this.state.email}
                            onChange={this.handleEmailChange}
                            onBlur={this.validateEmail}
                        />
                        <div className='invalid-feedback'>{this.state.emailError}</div>
                    </div>
                    <div className='form-group'>
                        <label htmlFor='email'>Password</label>
                        <input
                            name='password'
                            className={`form-control ${this.state.passwordError ? 'is-invalid' : ''}`}
                            id='password'
                            type='password'
                            placeholder='Password'
                            value={this.state.password}
                            onChange={this.handlePasswordChange}
                            onBlur={this.validatePassword}
                        />
                        <div className='invalid-feedback'>{this.state.passwordError}</div>
                    </div>
                    <div className='form-group'>
                        <label htmlFor='email'>Confirm Password</label>
                        <input
                            name='passwordConf'
                            className={`form-control ${this.state.passwordConfError ? 'is-invalid' : ''}`}
                            id='passwordConf'
                            type='password'
                            placeholder='Confirm Password'
                            value={this.state.passwordConf}
                            onChange={this.handlePasswordConfChange}
                            onBlur={this.validatePasswordConf}
                        />
                        <div className='invalid-feedback'>{this.state.passwordConfError}</div>
                    </div>
                    <button type='submit' className='btn btn-success btn-block'>
                        Submit
                    </button>
                </form>
            );
        }
    }

    ReactDOM.render(<BasicForm/>, document.getElementById('root2'))


</script>