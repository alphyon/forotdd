<?php


class CreatePostsTest extends FeatureTestCase
{
    function test_a_user_create_post()
    {

        //having
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';
        $this->actingAs($user=$this->defaultUser());

        //when
        $this->visit(route('posts.create'))
            ->type($title,'title')
            ->type($content,'content')
            ->press('Publicar');

        //then
        $this->seeInDatabase('posts',[
            'title' => $title,
            'content' => $content,
            'pending' => true,
            'user_id'=>$user->id,
        ]);

        //result
        $this->see($title);
    }

    function test_creating_a_post_requires_authenticating()
    {


        //when
        $this->visit(route('posts.create'))
             ->seePageIs(route('login'));


    }

    function test_create_post_form_validation()
    {
        $this->actingAs($user=$this->defaultUser())
             ->visit(route('posts.create'))
             ->press('Publicar')
             ->seePageIs(route('posts.create'))
            ->seeInElement('#field_title .help-block','The title field is required')
            ->seeInElement('#field_content .help-block','The content field is required');
    }
}
