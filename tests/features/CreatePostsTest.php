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
}
